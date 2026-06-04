<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrganizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'organization_name'   => $this->organization_name,
            'description'         => $this->description,
            'address'             => $this->address,
            'city'                => $this->city,
            'province'            => $this->province,
            'website'             => $this->website,
            'logo'                => $this->logo ? Storage::url($this->logo) : null,
            'verification_status' => $this->verification_status,
            'verified_at'         => $this->verified_at?->format('d M Y'),
            'user' => $this->whenLoaded('user', fn() => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ]),
        ];
    }
}
