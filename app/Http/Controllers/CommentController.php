<?php

namespace App\Http\Controllers;

use App\DTOs\CommentDTO;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Card;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{


    public function store(StoreRequest $request, Card $card ,CommentService $commentService)
    {
       $commentDTO = CommentDTO::fromCreate($request->validated() ,$card, auth()->user());
        $comment = $commentService->createComment($commentDTO);

        return new CommentResource($comment);
    }

    public function index(Card $card  ,CommentService $commentService)
    {
        $comments = $commentService->getComments($card);

        return CommentResource::collection($comments);
    }
}
