<?php


namespace App\DTO;

use Illuminate\Database\Eloquent\Model;

class LikeDTO
{
    public Model $model;
    public int $userId;

    public function __construct(Model $model, int $userId)
    {
        $this->model = $model;
        $this->userId = $userId;
    }
}
