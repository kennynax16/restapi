<?php

namespace App\Services;

use App\Models\Card;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function createComment(Card $card, array $data): Comment
    {
        return Comment::create([
            'card_id' => $card->id,
            'user_id' => Auth::id(),
            'text' => $data['text'],
        ]);
    }

    public function getComments(Card $card)
    {
        return $card->comments()->with('user')->latest()->get();
    }
}
