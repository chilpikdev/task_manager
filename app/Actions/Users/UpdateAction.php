<?php

namespace App\Actions\Users;

use App\Exceptions\ApiErrorException;
use App\Actions\Traits\ResponseTrait;
use App\DTO\Users\UpdateDTO;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    public function __invoke(UpdateDTO $dto): JsonResponse
    {
        try {
            $user = User::findOrFail($dto->userId);

            if (auth()->id() == $dto->userId && $dto->active) {
                throw new Exception("Вы не сможете заблокировать себя!");
            }

            $data = [
                'name' => $dto->name,
                'position' => $dto->position,
                'birthday' => $dto->birthday,
                'phone' => $dto->phone,
                'phone_verified_at' => now(),
                'active' => $dto->active
            ];

            if ($dto->password) {
                $data['password'] = $dto->password;
            }

            $user->update($data);

            $user->syncRoles($dto->roleId);

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "User Updated"
            );
        } catch (Exception $ex) {
            throw new ApiErrorException(404, $ex->getMessage());
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "User not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
