<?php

namespace App\Services;

use App\DTOs\CommentDTO;
use App\Models\Card;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function createComment(CommentDTO $commentDTO): Comment
    {
        return Comment::create([
            'card_id' => $commentDTO->cardId,
            'user_id' => Auth::id(),
            'text' => $commentDTO->text,
        ]);
    }

    public function getComments(Card $card)
    {
        return $card->comments()->with('user')->latest()->get();
    }
}
