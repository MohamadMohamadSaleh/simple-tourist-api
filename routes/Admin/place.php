<?php

use App\Http\Controllers\Admin\Place\PlaceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'scope:admin'])
    ->controller(PlaceController::class)
    ->group(function () {
        Route::post('places/create', 'create')
            ->name('places.create');

        Route::post('places/{place}/add-product', 'addProduct')
            ->name('places.addProduct');
    });
