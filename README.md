REST API для карточек с лайками и комментариями

Этот проект представляет собой REST API, разработанный на Laravel 9 и Vue 3. API позволяет пользователям создавать карточки, ставить лайки и оставлять комментарии.

🔧 Стек технологий

Backend: Laravel 9 (PHP)

Frontend: Vue 3

База данных: MySQL

Аутентификация: Laravel Sanctum

Дополнительно: Open Server 6

🚀 Установка и запуск

1️⃣ Клонирование репозитория

git clone https://github.com/kennynax16/restapi.git
cd restapi

2️⃣ Установка зависимостей

composer install
npm install

3️⃣ Настройка окружения

Создай файл .env на основе .env.example:

cp .env.example .env

Сгенерируй ключ приложения:

php artisan key:generate

4️⃣ Настройка базы данных

Отредактируй .env и пропиши параметры подключения к базе. Затем выполни миграции:

php artisan migrate --seed

5️⃣ Настройка Sanctum

Опубликуй конфиг и выполни команду для генерации токенов:

php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

Добавь Sanctum в kernel.php:

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

'api' => [
    EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],

6️⃣ Запуск сервера

php artisan serve

Запустить фронтенд:

npm run dev



👤 Автор

kennynax16GitHub: https://github.com/kennynax16

