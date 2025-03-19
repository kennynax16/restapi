<?php

namespace App\Services;

use App\DTOs\CommentDTO;
use App\Models\Card;
use App\Models\Comment;
use App\Repositories\Contracts\ICommentRepository;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected ICommentRepository $commentRepository;

    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function createComment(CommentDTO $commentDTO): Comment
    {
        return $this->commentRepository->create([
            'card_id' => $commentDTO->cardId,
            'user_id' => Auth::id(),
            'text' => $commentDTO->text,
        ]);
    }

    public function getComments(Card $card)
    {
        return $this->commentRepository->getByCard($card);
    }
}
