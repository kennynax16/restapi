<?php

namespace App\Repositories;

use App\Models\Card;
use App\Models\Comment;
use App\Repositories\Contracts\ICommentRepository;

class CommentRepository implements ICommentRepository
{
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function getByCard(Card $card)
    {
        return $card->comments()->with('user')->latest()->get();
    }
}
