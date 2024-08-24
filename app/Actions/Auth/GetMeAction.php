<?php

namespace App\Actions\Auth;

use App\Exceptions\ApiErrorException;
use App\Http\Resources\Auth\UserResource;

class GetMeAction
{
    public function __invoke(): UserResource
    {
        try {
            return new UserResource(auth()->user());
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
