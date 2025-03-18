<?php
namespace App\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function addLike($userId)
    {
        return $this->likes()->firstOrCreate(['user_id' => $userId]);
    }

    public function removeLike($userId)
    {
        return $this->likes()->where('user_id', $userId)->delete();
    }
}
