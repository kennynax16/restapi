<?php
namespace App\Repositories;

use App\Models\Card;
use App\Repositories\Contracts\ICardRepository;

class CardRepository implements ICardRepository

{
    public function create(array $data): Card
    {
        return Card::create($data);
    }

    public function update(Card $card, array $data): Card
    {
        $card->update($data);
        return $card;
    }
}
