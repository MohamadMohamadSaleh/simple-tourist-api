<?php

use App\Http\Controllers\Admin\Client\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login')
        ->name('admins.login');

    Route::get('logout', 'logout')
        ->middleware(['auth:api'])
        ->name('admins.logout');
});
