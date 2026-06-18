<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VolunteerProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'city'                => $this->city,
            'province'            => $this->province,
            'date_of_birth'       => $this->date_of_birth?->format('Y-m-d'),
            'gender'              => $this->gender,
            'bio'                 => $this->bio,
            'skills'              => $this->skills ?? [],
            'interests'           => $this->interests ?? [],
            'avatar'              => $this->avatar ? Storage::url($this->avatar) : null,
            'total_events_joined' => $this->total_events_joined,
        ];
    }
}