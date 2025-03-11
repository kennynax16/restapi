<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/cards', [CardController::class, 'index']);
    Route::post('/cards', [CardController::class, 'store']);
    Route::get('/cards/{card}', [CardController::class, 'show']);
    Route::put('/cards/{card}', [CardController::class, 'update']);
    Route::delete('/cards/{card}', [CardController::class, 'destroy']);

    Route::post('/cards/{card}/like', [LikeController::class, 'toggleLike']);

    Route::get('/cards/{card}/comments', [CommentController::class, 'index']);
    Route::post('/cards/{card}/comments', [CommentController::class, 'store']);
});
