<?php

namespace App\Services;

use App\Models\Card;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function toggleLike(Card $card): array
    {
        $userId = Auth::id();
        $existingLike = Like::where('card_id', $card->id)->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete();
            return [
                'isLiked' => false,
                'likeCount' => $card->likes()->count(),
                'latestLike' => null
            ];
        }

        $latestLike = $card->likes()->create(['user_id' => $userId]);

        return [
            'isLiked' => true,
            'likeCount' => $card->likes()->count(),
            'latestLike' => $latestLike
        ];
    }
}
