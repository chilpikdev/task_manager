<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
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
            'role' => $this->getRoleNames(),
            'birthday' => $this->birthday->format('d.m.Y'),
            'phone' => $this->phone,
            'active' => $this->active,
        ];
    }
}
