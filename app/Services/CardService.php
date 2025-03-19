<?php

namespace App\Services;

use App\DTOs\CardDTO;
use App\Models\Card;
use App\Repositories\Contracts\ICardRepository;
use App\Services\Contracts\ICardService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CardService implements ICardService

{

    private ICardRepository $cardRepository;
    private FileService $fileService;

    public function __construct(ICardRepository $cardRepository, FileService $fileService)
    {
        $this->cardRepository = $cardRepository;
        $this->fileService = $fileService;
    }
    public function createCard(CardDTO $cardDTO ): Card
    {
        $data = [
            'user_id' => Auth::id(),
            'name' => $cardDTO->name,
            'description' => $cardDTO->description ?? null,
            'url_photo' => $cardDTO->photo ? $this->fileService->upload($cardDTO->photo) : null,
        ];

        return $this->cardRepository->create($data);
    }

    public function updateCard(Card $card, CardDTO $cardDTO): Card
    {
        $data = [
            'name' => $cardDTO->name,
            'description' => $cardDTO->description ?? null,
        ];

        // Если загружен новый файл — обновляем фото
        if ($cardDTO->photo instanceof UploadedFile) {
            $data['url_photo'] = $this->fileService->update($card->url_photo, $cardDTO->photo);
        }

        return $this->cardRepository->update($card, $data);
    }

    public function deleteCard(Card $card): void
    {
        $card->delete();
    }
}
