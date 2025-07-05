<?php
// File: app/Http/Resources/UserResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name');
            }),
            'email_verified_at' => $this->email_verified_at?->toISOString(),
            'profile_photo_url' => $this->profile_photo_url,

            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}