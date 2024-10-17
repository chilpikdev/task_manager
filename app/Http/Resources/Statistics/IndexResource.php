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
            'name' => $this->name,
            'points' => $this->points,
            'completed' => [
                'on_time' => $this->completed_on_time_high + $this->completed_on_time_medium,
                // 'on_time' => [
                //     'high' => $this->completed_on_time_high,
                //     'medium' => $this->completed_on_time_medium,
                // ],
                'expired' => $this->completed_expired_high + $this->completed_expired_medium,
                // 'expired' => [
                //     'high' => $this->completed_expired_high,
                //     'medium' => $this->completed_expired_medium,
                // ],
            ],
            'unfulfilled' => [
                'active' => $this->unfulfilled_active_high + $this->unfulfilled_active_medium,
                // 'active' => [
                //     'high' => $this->unfulfilled_active_high,
                //     'medium' => $this->unfulfilled_active_medium
                // ],
                'expired' => $this->unfulfilled_expired_high + $this->unfulfilled_expired_medium,
                // 'expired' => [
                //     'high' => $this->unfulfilled_expired_high,
                //     'medium' => $this->unfulfilled_expired_medium
                // ],
            ]
        ];
    }
}
