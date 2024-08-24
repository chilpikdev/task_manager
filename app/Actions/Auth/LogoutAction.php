<?php

namespace App\Actions\Auth;

use App\Exceptions\ApiErrorException;
use Symfony\Component\HttpFoundation\JsonResponse;

class LogoutAction
{
    public function __invoke(): JsonResponse
    {
        try {
            auth()->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => __('auth.logout')
            ]);
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
