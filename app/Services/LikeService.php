<?php

namespace App\Services;

use App\Services\Contracts\ILikeService;
use App\DTO\LikeDTO;

class LikeService implements ILikeService
{
    public function like(LikeDTO $dto)
    {
        if (!method_exists($dto->model, 'likes')) {
            throw new \Exception("Model " . get_class($dto->model) . " does not support likes.");
        }

        return $dto->model->likes()->firstOrCreate(['user_id' => $dto->userId]);
    }

    public function unlike(LikeDTO $dto)
    {
        if (!method_exists($dto->model, 'likes')) {
            throw new \Exception("Model " . get_class($dto->model) . " does not support likes.");
        }

        return $dto->model->likes()->where('user_id', $dto->userId)->delete();
    }

    public function hasLiked(LikeDTO $dto): bool
    {
        if (!method_exists($dto->model, 'likes')) {
            return false;
        }

        return $dto->model->likes()->where('user_id', $dto->userId)->exists();
    }
}
