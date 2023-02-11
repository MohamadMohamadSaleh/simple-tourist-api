<?php

use App\Http\Controllers\Api\Place\PlaceController;
use App\Http\Controllers\Api\Place\PlaceTypeController;
use App\Http\Controllers\Api\Place\ProductController;
use App\Http\Controllers\Api\Place\ProductTypeController;
use App\Http\Controllers\Api\Place\SpecController;
use App\Http\Controllers\Api\Place\TagController;
use Illuminate\Support\Facades\Route;

Route::controller(PlaceTypeController::class)->group(function () {
    Route::get('place-types', 'index')
        ->name('place-types.index');
});

Route::controller(PlaceTypeController::class)->group(function () {
    Route::get('place-types/{type}', 'show')
        ->name('place-types.show');
});

Route::resource('places', PlaceController::class)
    ->only(['show', 'index']);

Route::resource('product-types/{placeType}', ProductTypeController::class)
    ->only(['index']);

Route::resource('products', ProductController::class)
    ->only(['index']);

Route::resource('specs', SpecController::class)
    ->only(['index']);

Route::resource('tags', TagController::class)
    ->only(['index']);
