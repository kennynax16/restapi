<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ILikeService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\DTO\LikeDTO;

class LikeController extends Controller
{
    private ILikeService $likeService;

    public function __construct(ILikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function like(Request $request, string $model, int $id)
    {
        $dto = new LikeDTO($this->findModel($model, $id), auth()->id());
        $this->likeService->like($dto);

        return response()->json(['message' => 'Liked!']);
    }

    public function unlike(Request $request, string $model, int $id)
    {
        $dto = new LikeDTO($this->findModel($model, $id), auth()->id());
        $this->likeService->unlike($dto);

        return response()->json(['message' => 'Unliked!']);
    }

    private function findModel(string $model, int $id)
    {
        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            throw new ModelNotFoundException("Model {$model} not found.");
        }

        return $modelClass::findOrFail($id);
    }
}
