<?php

namespace App\Services;

use App\DTOs\AuthDTO;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IAuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService implements IAuthService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Регистрация пользователя
     */
    public function registerUser(AuthDTO $authDTO ): User
    {
        return $this->userRepository->create([
            'name' => $authDTO->name,
            'email' => $authDTO->email,
            'password' => Hash::make($authDTO->password)
        ]);
    }

    /**
     * Аутентификация пользователя и выдача токена
     */
    public function loginUser(AuthDTO $authDTO): ?array
    {
        $user = $this->userRepository->findByEmail($authDTO->email);

        if (!$user || !Hash::check($authDTO->password, $user->password)) {
            return null; // Ошибка аутентификации
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * Выход пользователя (удаление токена)
     */
    public function logoutUser( User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
