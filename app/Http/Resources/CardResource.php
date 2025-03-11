<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'urlPhoto' => $this->url_photo
                ? asset('storage/' . $this->url_photo)
                : asset('storage/default.jpg'),
            'description' => $this->description,
            'likeCount' => $this->likes->count(),
            'isLiked' => $this->likes->contains('user_id', auth()->id() ?? 0),
        ];
    }
}
