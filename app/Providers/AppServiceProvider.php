<?php

namespace App\Providers;

use App\Enums\App\MorphTypes;
use App\Models\Journey\Journey;
use App\Models\Location\City;
use App\Models\Place\Place;
use App\Models\Place\PlaceType;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom([
            database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'Client',
            database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'Journey',
            database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'Location',
            database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'Place',
            database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'Product',
            database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'Tag'
        ]);

        Relation::enforceMorphMap([
            MorphTypes::PLACE => Place::class,
            MorphTypes::JOURNEY => Journey::class,
            MorphTypes::CITY => City::class,
            MorphTypes::PLACE_TYPE => PlaceType::class,
            MorphTypes::PRODUCT => Product::class
        ]);
    }
}
