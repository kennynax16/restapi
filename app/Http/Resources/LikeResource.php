<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    public function toArray( $request): array
    {
        return [
            'id' => $this->id,
            'card_id' => $this->card_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
