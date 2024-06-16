<?php

use Illuminate\Support\Facades\Route;

Route::any('/telegram', \App\Http\Controllers\TelegramController::class)
    ->middleware(\App\Http\Middleware\BotMiddleware::class)
    ->name('telegram.bot');
