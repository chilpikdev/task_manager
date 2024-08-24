<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = 'user';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'phone' => $this->phone,
            'phone_verified_at' => $this->phone_verified_at,
            'active' => $this->active,
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->map(fn ($permission) => $permission->name),
        ];
    }
}
