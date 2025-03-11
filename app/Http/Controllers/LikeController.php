<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use App\Models\Card;
use App\Services\LikeService;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    protected LikeService $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function toggleLike(Card $card): JsonResponse
    {
        $result = $this->likeService->toggleLike($card);

        return response()->json([
            'isLiked' => $result['isLiked'],
            'likeCount' => $result['likeCount'],
            'latestLike' => $result['latestLike'] ? new LikeResource($result['latestLike']) : null,
        ]);
    }
}
