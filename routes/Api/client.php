<?php

use App\Http\Controllers\Api\Client\AuthController;
use App\Http\Controllers\Api\Client\ClientController;
use App\Http\Controllers\Api\Client\FavoriteController;
use App\Http\Controllers\Api\Client\FileController;
use App\Http\Controllers\Api\Client\ReviewController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login')
        ->name('login');

    Route::post('register', 'register')
        ->name('register');

    Route::get('logout', 'logout')
        ->middleware(['auth:api'])
        ->name('logout');
});

Route::controller(ClientController::class)->middleware(['auth:api'])->group(function () {
    Route::get('show/{user}', 'show')
        ->name('users.show');

    Route::get('show-profile', 'showProfile')
        ->name('users.profile');

    Route::put('update', 'update')
        ->name('users.update');

    Route::put('reset-password', 'changePassword')
        ->name('users.reset.password');

    Route::post('update-photo', 'updatePhoto')
        ->name('users.update.photo');
});

Route::controller(FileController::class)->middleware(['auth:api'])->group(function () {
    Route::post('upload', 'upload')
        ->name('users.upload');
});

Route::controller(FavoriteController::class)->middleware(['auth:api'])->group(function () {
    Route::post('favorites/add', 'add');
    Route::delete('favorites/remove', 'remove');
    Route::get('favorites', 'index');
});

Route::controller(ReviewController::class)->middleware(['auth:api'])->group(function () {
    Route::post('reviews/add', 'updateOrCreate')
        ->name('reviews.updateOrCreate');
});
