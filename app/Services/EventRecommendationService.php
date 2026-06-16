<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Registration;
use App\Models\VolunteerProfile;
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
        if (!empty($interests) && !is_numeric($interests[0])) {
            $interests = \App\Models\Category::whereIn('name', $interests)
                ->pluck('id')
                ->toArray();
        }

        $scored = $events->map(function (Event $event) use ($interests, $historyCategoryIds) {
            $categoryIds = $event->categories->pluck('id')->toArray();

            $interestScore = 0;
            if (!empty($interests) && !empty($categoryIds)) {
                $matched       = count(array_intersect($categoryIds, $interests));
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

            return [
                'event' => $event,
                'score' => $finalScore,
            ];
        });

        return $scored
            ->sortByDesc('score')
            ->filter(fn ($item) => $item['score'] > 0)   
            ->take($limit)
            ->pluck('event');
    }

    private function parseInterests(mixed $interests): array
    {
        if (is_array($interests)) {
            return array_map('intval', $interests);
        }

        if (is_string($interests)) {
            $decoded = json_decode($interests, true);
            if (is_array($decoded)) {
                return array_map('intval', $decoded);
            }
            
            return array_map('intval', array_filter(array_map('trim', explode(',', $interests))));
        }

        return [];
    }
}