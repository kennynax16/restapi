<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Card;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(StoreRequest $request, Card $card)
    {
        $validated = $request->validated();
        $comment = $this->commentService->createComment($card, $validated);
        return new CommentResource($comment);
    }

    public function index(Card $card)
    {
        $comments = $this->commentService->getComments($card);
        return CommentResource::collection($comments);
    }
}
