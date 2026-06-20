<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Registration;
use App\Models\VolunteerProfile;
use App\Models\Category;
use Illuminate\Support\Collection;

class EventRecommendationService
{
    /**
     * @param  int  $userId
     * @param  int  $limit
     * @return Collection
     */
    public function recommend(int $userId, int $limit = 6): Collection
    {
        $profile   = VolunteerProfile::where('user_id', $userId)->first();
        $interests = $this->parseInterests($profile?->interests ?? []);
        $interestCategoryIds = $this->resolveToIds($interests);

        $historyCategoryIds = Registration::where('user_id', $userId)
            ->whereIn('status', ['confirmed', 'attended'])
            ->with('event.categories')
            ->get()
            ->flatMap(fn ($reg) => $reg->event?->categories->pluck('id') ?? collect())
            ->countBy()
            ->toArray();

        $registeredEventIds = Registration::where('user_id', $userId)
            ->pluck('event_id');

        $events = Event::with('categories')
            ->where('status', 'published')
            ->where('end_date', '>=', now()->toDateString())
            ->whereNotIn('id', $registeredEventIds)
            ->get();

        if ($events->isEmpty()) {
            return collect();
        }

        $scored = $events->map(function (Event $event) use ($interestCategoryIds, $historyCategoryIds) {
            $categoryIds = $event->categories->pluck('id')->toArray();

            $interestScore = 0;
            if (!empty($interestCategoryIds) && !empty($categoryIds)) {
                $matched       = count(array_intersect($categoryIds, $interestCategoryIds));
                $interestScore = $matched / max(count($categoryIds), 1);
            }

            $historyScore = 0;
            if (!empty($historyCategoryIds) && !empty($categoryIds)) {
                $totalFreq = array_sum($historyCategoryIds);
                if ($totalFreq > 0) {
                    $matchedFreq = 0;
                    foreach ($categoryIds as $catId) {
                        $matchedFreq += $historyCategoryIds[$catId] ?? 0;
                    }
                    $historyScore = $matchedFreq / $totalFreq;
                }
            }

            $finalScore = ($interestScore * 0.6) + ($historyScore * 0.4);

            return ['event' => $event, 'score' => $finalScore];
        });

        $results = $scored
            ->sortByDesc('score')
            ->filter(fn ($item) => $item['score'] > 0)
            ->take($limit)
            ->pluck('event');

        if ($results->isEmpty()) {
            return Event::with('categories')
                ->where('status', 'published')
                ->where('end_date', '>=', now()->toDateString())
                ->whereNotIn('id', $registeredEventIds)
                ->orderBy('start_date')
                ->limit($limit)
                ->get();
        }

        return $results;
    }

    private function parseInterests(mixed $interests): array
    {
        if (is_array($interests)) {
            return array_values(array_filter(array_map('trim', $interests)));
        }

        if (is_string($interests) && $interests !== '') {
            $decoded = json_decode($interests, true);
            if (is_array($decoded)) {
                return array_values(array_filter(array_map('trim', $decoded)));
            }
            return array_values(array_filter(array_map('trim', explode(',', $interests))));
        }

        return [];
    }

    private function resolveToIds(array $values): array
    {
        if (empty($values)) {
            return [];
        }

        $allNumeric = array_reduce($values, fn($carry, $v) => $carry && is_numeric($v), true);

        if ($allNumeric) {
            return array_map('intval', $values);
        }

        return Category::whereIn('name', $values)
            ->pluck('id')
            ->toArray();
    }
}