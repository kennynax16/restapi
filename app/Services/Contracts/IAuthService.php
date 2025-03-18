<?php

namespace App\Services\Contracts;

use App\DTOs\AuthDTO;
use App\Models\User;

interface IAuthService
{
    public function registerUser(AuthDTO $authDTO): User;

    public function loginUser(AuthDTO $authDTO): ?array;

    public function logoutUser(User $user): void;
}
