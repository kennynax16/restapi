<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'card_id' => $this->card_id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ],
            'text' => $this->text,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
