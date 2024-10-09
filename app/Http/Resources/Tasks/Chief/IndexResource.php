<?php

namespace App\Http\Resources\Tasks\Chief;

use Carbon\Carbon;
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
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'actual_deadline' => $this->actual_deadline,
            'extend_deadline' => $this->extendDeadline(),
            'expired' => $this->actual_deadline <= now() ? true : false,
            'created_by' => $this->createdBy ? [
                'id' => $this->createdBy->id,
                'name' => $this->createdBy->name,
            ] : [],
            'assigned' => $this->users ? $this->users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                ];
            }) : [],
            'left' => Carbon::parse($this->actual_deadline)->fromNow(),
            'point' => $this->points()->first()?->point,
        ];
    }
}
