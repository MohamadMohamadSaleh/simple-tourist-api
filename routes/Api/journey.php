<?php

use App\Http\Controllers\Api\Journey\CategoryController;
use App\Http\Controllers\Api\Journey\JourneyController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoryController::class)->group(function () {
    Route::get('journey/category', 'index')
        ->name('journey_category.index');
});

Route::controller(JourneyController::class)->group(function () {
    Route::get('journeys', 'index')
        ->name('journeys.index');
});
