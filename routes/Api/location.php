<?php

use App\Http\Controllers\Api\Location\CityController;
use App\Http\Controllers\Api\Location\CountryController;
use Illuminate\Support\Facades\Route;

Route::controller(CountryController::class)->group(function () {
    Route::get('countries', 'index')
        ->name('countries.index');

    Route::get('countries/{country}', 'show')
        ->name('countries.show');
});

Route::controller(CityController::class)->group(function () {
    Route::get('countries/{country}/cities', 'index')
        ->name('countries.cities.index');

    Route::get('countries/{country}/cities/{city}', 'show')
        ->scopeBindings()
        ->name('countries.cities.show');
});
