<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface IUserRepository
{
    public function create(array $data): User;

    public function findByEmail(string $email): ?User;
}
