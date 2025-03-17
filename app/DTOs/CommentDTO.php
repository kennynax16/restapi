<?php

namespace App\DTOs;

use App\Models\Card;
use App\Models\User;

class CommentDTO
{
    public function __construct(
        public string $text,
        public int $cardId,
        public int $userId
    ) {}

    public static function fromCreate(array $data, Card $card, User $user): self
    {
        return new self(
            text: $data['text'],
            cardId: $card->id,
            userId: $user->id
        );
    }
}
