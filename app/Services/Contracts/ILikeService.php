<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ILikeService
{
    public function like(Model $model, int $userId);
    public function unlike(Model $model, int $userId);
    public function hasLiked(Model $model, int $userId): bool;
}
