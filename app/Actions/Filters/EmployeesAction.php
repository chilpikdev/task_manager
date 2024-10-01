<?php

namespace App\Actions\Filters;

use App\Exceptions\ApiErrorException;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Http\Resources\Filters\EmployeesResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class EmployeesAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(): AnonymousResourceCollection
    {
        try {
            $items = Cache::remember("filter_employees" . $this->generateKey(), now()->addDay(), function () {
                return User::role(roles: 'employee')->where('active', true)->get();
            });

            return EmployeesResource::collection($items);
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
