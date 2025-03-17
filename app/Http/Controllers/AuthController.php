<?php

namespace App\Http\Controllers;

use App\DTOs\AuthDTO;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{


    /**
     * Регистрация пользователя
     */
    public function register(RegisterRequest $request ,AuthService $authService)
    {
        $authDTO = AuthDTO::fromArray($request->validated());
        $user = $authService->registerUser($authDTO);

        return response()->json([
            'user' => new UserResource($user),
            'message' => 'Registered successfully'
        ], 201);
    }

    /**
     * Вход пользователя
     */
    public function login(LoginRequest $request  ,AuthService $authService)
    {

        $authDTO = AuthDTO::fromArray($request->validated());
        // Передаём его в сервис
        $result = $authService->loginUser($authDTO);

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
    public function logout(Request $request ,AuthService $authService)
    {
        $authService->logoutUser($request->user());

        return response()->json(['message' => 'Logged out']);
    }
}
