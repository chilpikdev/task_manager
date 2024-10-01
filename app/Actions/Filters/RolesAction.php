<?php

namespace App\Actions\Filters;

use App\Exceptions\ApiErrorException;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Http\Resources\Filters\RolesResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class RolesAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(): AnonymousResourceCollection
    {
        try {
            $items = Cache::remember("filter_roles" . $this->generateKey(), now()->addDay(), function () {
                return Role::all();
            });

            return RolesResource::collection($items);
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
