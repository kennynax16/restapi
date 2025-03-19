<?php

namespace App\Repositories\Contracts;

use App\Models\Card;
use App\Models\Comment;

interface ICommentRepository
{
    public function create(array $data): Comment;
    public function getByCard(Card $card);
}
