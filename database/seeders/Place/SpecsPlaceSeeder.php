<?php

namespace Database\Seeders\Place;

use App\Models\Place\Place;
use App\Models\Place\PlaceType;
use App\Models\Place\Specs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpecsPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specs_places')->truncate();
        $type = PlaceType::select(['id'])->where('name', '=', 'مطاعم')->first();
        $places = Place::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->toArray();
        Specs::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->each(function ($specs) use ($places) {
                $specsPlaces = [];
                foreach ($places as $place) {
                    $specsPlaces[] = [
                        'id' => Str::orderedUuid()->toString(),
                        'specs_id' => $specs->id,
                        'place_id' =>$place['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('specs_places')->insert($specsPlaces);
            });
        $type = PlaceType::select(['id'])->where('name', '=', 'فنادق')->first();
        $places = Place::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->toArray();
        Specs::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->each(function ($specs) use ($places) {
                $specsPlaces = [];
                foreach ($places as $place) {
                    $specsPlaces[] = [
                        'id' => Str::orderedUuid()->toString(),
                        'specs_id' => $specs->id,
                        'place_id' =>$place['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('specs_places')->insert($specsPlaces);
            });
    }
}
