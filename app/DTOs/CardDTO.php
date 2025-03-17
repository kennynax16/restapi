<?php

namespace App\DTOs;

use App\Models\Card;
use Illuminate\Http\UploadedFile;

class CardDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string|UploadedFile|null $photo // Теперь тут либо путь, либо файл
    ) {}

    public static function fromCreate(array $data , int $id): self
    {
        return new self(
            id: 0, // При создании ID ещё нет, можно задать 0 или null
            name: $data['name'] ?? '',
            description: $data['description'],
            photo: $data['photo']
        );
    }

  public  static function fromUpdate(array $data ,Card $card): self
  {
      return new self(
          id: $card->id,
          name: $data['name'],
          description: $data['description'],
          photo: isset($data['photo']) && $data['photo'] instanceof UploadedFile
              ? $data['photo']
              : $card->url_photo // Оставляем старое фото, если новое не загружено
      );
  }
}

