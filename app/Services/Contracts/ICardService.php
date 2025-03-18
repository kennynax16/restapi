<?php

namespace App\Services\Contracts;

use App\DTOs\CardDTO;
use App\Models\Card;

interface ICardService
{
    public function createCard(CardDTO $cardDTO): Card;
    public function updateCard(Card $card, CardDTO $cardDTO): Card;
    public function deleteCard(Card $card): void;
}
