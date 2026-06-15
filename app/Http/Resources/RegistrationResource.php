<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'status'              => $this->status,
            'registered_at'       => $this->registered_at?->format('d M Y H:i'),
            'cancelled_at'        => $this->cancelled_at?->format('d M Y H:i'),
            'cancellation_reason' => $this->cancellation_reason,
            'notes'               => $this->notes,
            'event' => $this->whenLoaded('event', fn() => new EventResource($this->event)),
            'user'  => $this->whenLoaded('user',  function () {
                $user = $this->user;
                $regs = $user->registrations;

                return (new UserResource($user))->additional([])->toArray(request()) + [
                    'volunteer_stats' => [
                        'total_daftar'    => $regs->count(),
                        'total_confirmed' => $regs->where('status', 'confirmed')->count(),
                        'total_hadir'     => $regs->where('status', 'attended')->count(),
                        'total_batal'     => $regs->where('status', 'cancelled')->count(),
                    ],
                    'registration_history' => $regs
                        ->whereIn('status', ['confirmed', 'attended', 'cancelled'])
                        ->sortByDesc('registered_at')
                        ->values()
                        ->map(fn($r) => [
                            'event_title' => $r->event?->title,
                            'start_date'  => $r->event?->start_date?->format('Y-m-d'),
                            'city'        => $r->event?->city,
                            'status'      => $r->status,
                        ]),
                ];
            }),
        ];
    }
}