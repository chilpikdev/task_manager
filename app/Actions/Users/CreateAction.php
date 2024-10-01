<?php

namespace App\Actions\Users;

use App\Exceptions\ApiErrorException;
use App\Actions\Traits\ResponseTrait;
use App\DTO\Users\CreateDTO;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDTO $dto): JsonResponse
    {
        try {
            $data = [
                'name' => $dto->name,
                'position' => $dto->position,
                'birthday' => $dto->birthday,
                'phone' => $dto->phone,
                'phone_verified_at' => now(),
                'password' => $dto->password,
                'active' => $dto->active
            ];

            $user = User::create($data);

            $user->assignRole($dto->roleId);

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "User Created"
            );
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
