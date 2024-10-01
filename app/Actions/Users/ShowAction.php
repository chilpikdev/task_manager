<?php

namespace App\Actions\Users;

use App\Exceptions\ApiErrorException;
use App\Actions\Traits\ResponseTrait;
use App\Http\Resources\Users\ShowResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowAction
{
    use ResponseTrait;

    public function __invoke(int $id): ShowResource
    {
        try {
            $user = User::findOrFail($id);
            return new ShowResource($user);
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "User not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
