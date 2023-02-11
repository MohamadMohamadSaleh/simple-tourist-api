<?php

namespace Database\Seeders\Place;

use App\Models\Place\PlaceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlaceType::all()->each(function ($placeType){
            $placeType->clearMediaCollection();
        });

        DB::table('place_types')->truncate();

        $placeTypes = [
            [
                'name' => 'مغامرات',
                'icon' => 'camping.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'أماكن أثرية',
                'icon' => 'ruins.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'متاحف',
                'icon' => 'museum.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'فنادق',
                'icon' => '5-stars.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'مطاعم',
                'icon' => 'restaurant.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'مراكز تسوق',
                'icon' => 'shopping-cart.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'مدن ملاهي',
                'icon' => 'amusement-park.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        foreach ($placeTypes as $placeType) {
            $icon = storage_path('images/icons/'  . $placeType['icon']);
            unset($placeType['icon']);
            $typeObject = (new PlaceType())->create($placeType);
            $typeObject->copyMedia($icon)->toMediaCollection();
        }
    }
}
