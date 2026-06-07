<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'description'      => $this->description,
            'poster'           => $this->poster ? Storage::url($this->poster) : null,
            'location_name'    => $this->location_name,
            'location_address' => $this->location_address,
            'city'             => $this->city,
            'province'         => $this->province,
            'start_date'       => $this->start_date?->format('d M Y'),
            'end_date'         => $this->end_date?->format('d M Y'),
            'start_time'       => $this->start_time,
            'end_time'         => $this->end_time,
            'quota'            => $this->quota,
            'registered_count' => $this->registered_count,
            'likes_count'      => $this->likes_count ?? 0,
            'remaining_quota'  => $this->remainingQuota(),
            'is_full'          => $this->isFull(),
            'status'           => $this->status,
            'requirements'     => $this->requirements,
            'contact_person'   => $this->contact_person,
            'contact_phone'    => $this->contact_phone,
            'created_at'       => $this->created_at?->format('d M Y'),
            'categories'       => $this->whenLoaded('categories'),
            'organization'     => $this->whenLoaded(
                'organization',
                fn() => new OrganizationResource($this->organization)
            ),
        ];
    }
}