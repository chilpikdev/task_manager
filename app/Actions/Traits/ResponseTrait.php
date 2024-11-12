<?php

namespace App\Actions\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * Summary of toResponse
     * @param int $code = 200
     * @param array $headers = []
     * @param mixed $message
     * @param array|\Illuminate\Database\Eloquent\Collection $items
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse(int $code = 200, ?array $headers = null, ?string $message = null, array|Collection|null $items = null): JsonResponse
    {
        $data = [
            'code' => $code,
        ];

        if ($message) {
            $data['message'] = $message;
        }

        if ($items) {
            $data['data'] = $items;
        }

        return response()->json(
            data: $data,
            status: $code,
            headers: $headers
        );
    }
}
