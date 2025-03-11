<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->words(2, true),
            'url_photo' => $this->generateRandomImage(),
            'description' => $this->faker->paragraph(),
        ];
    }

    /**
     * Генерация случайного изображения в storage/app/public/uploads
     * и возврат пути вида 'uploads/имя_файла.jpg'
     */
    private function generateRandomImage()
    {

        $fileName = uniqid() . '.jpg';

        $filePath = 'uploads/' . $fileName;


        $image = imagecreatetruecolor(640, 480);
        $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        imagefill($image, 0, 0, $color);


        ob_start();
        imagejpeg($image, null, 80);
        $imageContent = ob_get_clean();

        Storage::disk('public')->put($filePath, $imageContent);

        imagedestroy($image);

        return $filePath;
    }
}
