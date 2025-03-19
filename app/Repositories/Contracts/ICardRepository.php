<?php
namespace App\Repositories\Contracts;

use App\Models\Card;

interface ICardRepository
{
    public function create(array $data): Card;
    public function update( Card $card ,array $data): Card;
}
