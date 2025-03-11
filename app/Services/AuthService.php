<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Регистрация пользователя
     */
    public function registerUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']); // Хешируем пароль
        return User::create($data);
    }

    /**
     * Аутентификация пользователя и выдача токена
     */
    public function loginUser(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            return ['error' => 'Invalid credentials'];
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * Выход пользователя (удаление токена)
     */
    public function logoutUser($user): void
    {
        $user->currentAccessToken()->delete();
    }
}
