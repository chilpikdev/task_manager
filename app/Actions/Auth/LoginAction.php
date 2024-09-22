<?php

namespace App\Actions\Auth;

use App\DTO\Auth\LoginDTO;
use App\Exceptions\ApiErrorException;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function __invoke(LoginDTO $dto): JsonResponse
    {
        try {
            $user = User::where('phone', $dto->phone)->firstOrFail();
            $expiresAt = now()->addMinutes(config('sanctum.expiration'));

            if (Hash::check($dto->password, $user->password)) {
                auth()->login($user);

                return response()->json([
                    'message' => __('auth.logged_id'),
                    'token' => auth()->user()->createToken('API TOKEN', ['*'], $expiresAt)->plainTextToken,
                    'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                    'user' => new UserResource(auth()->user())
                ]);
            } else {
                throw new AuthenticationException;
            }
        } catch (AuthenticationException $ex) {
            throw new ApiErrorException(401, __('auth.unauthenticated'));
        } catch (ModelNotFoundException $ex) {
            throw new ApiErrorException(404, __('auth.failed'));
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
