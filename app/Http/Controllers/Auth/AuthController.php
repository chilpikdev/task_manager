<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\GetMeAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\DTO\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GetMeRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Login
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action(LoginDTO::from($request));
    }

    /**
     * Get Me
     */
    public function getMe(GetMeRequest $request, GetMeAction $action): UserResource
    {
        return $action();
    }

    /**
     * Login
     */
    public function logout(LogoutRequest $request, LogoutAction $action): JsonResponse
    {
        return $action();
    }
}
