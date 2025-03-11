<?php

namespace App\Services;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardService
{
    public function createCard(array $data, Request $request): Card
    {
        $card = new Card();
        $card->user_id = Auth::id();
        $card->name = $data['name'];
        $card->description = $data['description'] ?? null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('uploads', 'public');
            $card->url_photo = $path;
        }

        $card->save();
        return $card;
    }

    public function updateCard(Card $card, array $data, Request $request): Card
    {
        $card->name = $data['name'];
        $card->description = $data['description'] ?? $card->description;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('uploads', 'public');
            $card->url_photo = $path;
        }

        $card->save();
        return $card;
    }

    public function deleteCard(Card $card): void
    {
        $card->delete();
    }
}
