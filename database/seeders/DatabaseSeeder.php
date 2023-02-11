<?php

namespace Database\Seeders;

use Database\Seeders\Client\UserSeeder;
use Database\Seeders\Journey\CategorySeeder;
use Database\Seeders\Journey\JourneyPlaceSeeder;
use Database\Seeders\Journey\JourneySeeder;
use Database\Seeders\Journey\JourneyStationSeeder;
use Database\Seeders\Location\AddressSeeder;
use Database\Seeders\Location\CitySeeder;
use Database\Seeders\Location\CountrySeeder;
use Database\Seeders\Place\OptionPlaceSeeder;
use Database\Seeders\Place\OptionSeeder;
use Database\Seeders\Place\PlaceSeeder;
use Database\Seeders\Place\PlaceTypeSeeder;
use Database\Seeders\Place\ReviewSeeder;
use Database\Seeders\Place\SpecsPlaceSeeder;
use Database\Seeders\Place\SpecsSeeder;
use Database\Seeders\Product\ProductSeeder;
use Database\Seeders\Product\ProductTypeSeeder;
use Database\Seeders\Tag\PlaceTagSeeder;
use Database\Seeders\Tag\PlaceTypeTagSeeder;
use Database\Seeders\Tag\TagSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('media')->truncate();
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            TagSeeder::class,
            PlaceTypeSeeder::class,
            PlaceSeeder::class,
            PlaceTypeTagSeeder::class,
            PlaceTagSeeder::class,
            SpecsSeeder::class,
            SpecsPlaceSeeder::class,
            OptionSeeder::class,
            OptionPlaceSeeder::class,
            AddressSeeder::class,
            CategorySeeder::class,
            ProductTypeSeeder::class,
            ProductSeeder::class,
            JourneySeeder::class,
            JourneyStationSeeder::class,
            JourneyPlaceSeeder::class,
            ReviewSeeder::class
        ]);
        DB::statement("SET foreign_key_checks=1");
    }
}
