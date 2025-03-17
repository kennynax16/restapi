<?php

namespace App\Services;

use App\DTOs\AuthDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Регистрация пользователя
     */
    public function registerUser(AuthDTO $authDTO): User
    {

        return User::create([

            'name' => $authDTO->name,
            'email' => $authDTO->email,
            'password' => Hash::make($authDTO->password),]);
    }

    /**
     * Аутентификация пользователя и выдача токена
     */
    public function loginUser(AuthDTO $authDTO): array
    {
        if (!Auth::attempt($authDTO->toArray())) {
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
