<?php

use App\Admin\Controllers\CanvasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::post('/login', [\App\Admin\Controllers\Auth\AuthController::class, 'loginForm']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/getUser', [\App\Admin\Controllers\Auth\AuthController::class, 'getUser']);
        Route::get('/getSession', [\App\Admin\Controllers\Auth\AuthController::class, 'getSession']);
    });


    Route::prefix('users')->group(function () {
        Route::get('/getUsers', [\App\Admin\Controllers\UsersController::class, 'getUsers']);
    });

    Route::prefix('services')->group(function () {
        Route::get('/getConfig', [\App\Admin\Controllers\ServicesController::class, 'getConfig']);
        Route::get('/getMain', [\App\Admin\Controllers\ServicesController::class, 'getMain']);
    });

    Route::prefix('language')->group(function () {
        Route::get('/getLanguages', [\App\Admin\Controllers\LanguageController::class, 'getLanguages']);
        Route::post('/setStatus', [\App\Admin\Controllers\LanguageController::class, 'setStatus']);
    });

    Route::prefix('settings')->group(function () {
        Route::get('/getSettings', [\App\Admin\Controllers\SettingsController::class, 'getSettings']);
        Route::post('/setSettings', [\App\Admin\Controllers\SettingsController::class, 'setSettings']);
    });
});


Route::get('/', [CanvasController::class, 'canvas'])
    ->name('admin.canvas');

Route::get('/{route}', [CanvasController::class, 'canvas'])
    ->where('route', '.*')
    ->name('admin.canvas.route');
