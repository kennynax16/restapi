<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Регистрация пользователя
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->registerUser($request->validated());

        return response()->json([
            'user' => new UserResource($user),
            'message' => 'Registered successfully'
        ], 201);
    }

    /**
     * Вход пользователя
     */
    public function login(LoginRequest $request)
    {
        $result = $this->authService->loginUser($request->validated());

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], 401);
        }

        return response()->json([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
            'message' => 'Logged in'
        ]);
    }

    /**
     * Выход пользователя
     */
    public function logout(Request $request)
    {
        $this->authService->logoutUser($request->user());

        return response()->json(['message' => 'Logged out']);
    }
}
