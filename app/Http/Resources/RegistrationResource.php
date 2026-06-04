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
            'user'  => $this->whenLoaded('user',  fn() => new UserResource($this->user)),
        ];
    }
}