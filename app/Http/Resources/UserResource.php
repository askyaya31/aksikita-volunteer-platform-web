<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $regs = $this->whenLoaded('registrations');

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'role'       => $this->role,
            'phone'      => $this->phone,
            'avatar'     => $this->avatar ? Storage::url($this->avatar) : null,
            'is_active'  => $this->is_active,
            'created_at' => $this->created_at?->format('d M Y'),

            'volunteer_profile' => $this->whenLoaded('volunteerProfile',
                fn() => new VolunteerProfileResource($this->volunteerProfile)
            ),
            'organization_profile' => $this->whenLoaded('organizationProfile'),

            // Hanya muncul kalau relasi registrations di-load
            'volunteer_stats' => $this->when(
                $this->relationLoaded('registrations'),
                fn() => [
                    'total_daftar'    => $this->registrations->count(),
                    'total_confirmed' => $this->registrations->where('status', 'confirmed')->count(),
                    'total_hadir'     => $this->registrations->where('status', 'attended')->count(),
                    'total_batal'     => $this->registrations->where('status', 'cancelled')->count(),
                ]
            ),
            'registration_history' => $this->when(
                $this->relationLoaded('registrations'),
                fn() => $this->registrations
                    ->whereIn('status', ['confirmed', 'attended', 'cancelled'])
                    ->sortByDesc('registered_at')
                    ->values()
                    ->map(fn($r) => [
                        'event_title' => $r->event?->title,
                        'start_date'  => $r->event?->start_date?->format('Y-m-d'),
                        'city'        => $r->event?->city,
                        'status'      => $r->status,
                    ])
            ),
        ];
    }
}