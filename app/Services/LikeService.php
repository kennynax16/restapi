<?php
namespace App\Services;

use App\Models\Card;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeService {
    public function toggleLike(Card $card) {
        $user = Auth::user();
        $like = Like::where('card_id', $card->id)->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete(); // Удаляем лайк, если уже есть
            return false;
        } else {
            Like::create([
                'card_id' => $card->id,
                'user_id' => $user->id,
            ]);
            return true;
        }
    }
}
