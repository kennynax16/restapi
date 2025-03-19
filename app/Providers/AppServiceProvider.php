<?php

namespace App\Providers;

use App\Repositories\CardRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Contracts\ICardRepository;
use App\Repositories\Contracts\ICommentRepository;
use App\Services\AuthService;
use App\Services\CardService;
use App\Services\Contracts\IAuthService;
use App\Services\Contracts\ICardService;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\FileService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ICommentRepository::class, CommentRepository::class);
        $this->app->bind(ICardRepository::class, CardRepository::class);
        $this->app->bind(ICardService::class, CardService::class);
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->singleton(FileService::class, function ($app) {
            return new FileService();
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
