<?php

namespace App\Services;

use App\DTOs\CardDTO;
use App\Models\Card;
use App\Services\Contracts\ICardService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CardService implements ICardService
{
    public function createCard(CardDTO $cardDTO): Card
    {
        $card = new Card();
        $card->user_id = Auth::id(); // Привязываем карточку к пользователю
        $card->name = $cardDTO->title; // Используем DTO
        $card->description = $cardDTO->description ?? null;

        // Проверяем, есть ли изображение
        if (!empty($cardDTO->photo) && $cardDTO->photo instanceof \Illuminate\Http\UploadedFile) {
            $path = $cardDTO->photo->store('uploads', 'public');
            $card->url_photo = $path;
        }

        $card->save();
        return $card;
    }

    public function updateCard(Card $card, CardDTO $cardDTO): Card
    {
        $card->name = $cardDTO->name;
        $card->description = $cardDTO->description;

        // Если загружен новый файл — обновляем фото
        if ($cardDTO->photo instanceof UploadedFile) {
            // Удаляем старое фото, если оно есть
            if (!empty($card->url_photo)) {
                Storage::disk('public')->delete($card->url_photo);
            }

            // Загружаем новое фото
            $path = $cardDTO->photo->store('uploads', 'public');
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
