<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Services\Contracts\ILikeService;
use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\DTO\LikeDTO;

class LikeController extends Controller
{

    public function like(Card $card, LikeService $cardLikeService) {
        $liked = $cardLikeService->toggleLike($card);
        return response()->json(['liked' => $liked]);
    }
}
