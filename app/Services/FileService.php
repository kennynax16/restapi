<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        return $file->store($folder, 'public');
    }

    public function update(?string $oldPath, UploadedFile $newFile): string
    {
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $newFile->store('uploads', 'public');
    }

}
