<?php

namespace Database\Seeders\Place;

use App\Models\Place\Option;
use App\Models\Place\Specs;
use App\Models\Place\SpecsPlace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OptionPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('option_places')->truncate();
        $specs = Specs::select(['id'])->where('name', '=', 'الأطباق')->first();
        $specsPlaces = SpecsPlace::select(['id'])->where('specs_id', $specs->id)
            ->get()
            ->toArray();
        Option::select(['id'])->where('specs_id', $specs->id)
            ->get()
            ->each(function ($option) use ($specsPlaces) {
                $optionPlaces = [];
                foreach ($specsPlaces as $specsPlace) {
                    $optionPlaces[] = [
                        'id' => Str::orderedUuid()->toString(),
                        'option_id' => $option['id'],
                        'specs_place_id' => $specsPlace['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('option_places')->insert($optionPlaces);
            });
        DB::table('option_places')->truncate();
        $specs = Specs::select(['id'])->where('name', '=', 'الوجبات')->first();
        $specsPlaces = SpecsPlace::select(['id'])->where('specs_id', $specs->id)
            ->get()
            ->toArray();
        Option::select(['id'])->where('specs_id', $specs->id)
            ->get()
            ->each(function ($option) use ($specsPlaces) {
                $optionPlaces = [];
                foreach ($specsPlaces as $specsPlace) {
                    $optionPlaces[] = [
                        'id' => Str::orderedUuid()->toString(),
                        'option_id' => $option['id'],
                        'specs_place_id' => $specsPlace['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('option_places')->insert($optionPlaces);
            });
        $specs = Specs::select(['id'])->where('name', '=', 'عدد الغرف')->first();
        $specsPlaces = SpecsPlace::select(['id'])->where('specs_id', $specs->id)
            ->get()
            ->toArray();
        Option::select(['id'])->where('specs_id', $specs->id)
            ->get()
            ->each(function ($option) use ($specsPlaces) {
                $optionPlaces = [];
                foreach ($specsPlaces as $specsPlace) {
                    $optionPlaces[] = [
                        'id' => Str::orderedUuid()->toString(),
                        'option_id' => $option['id'],
                        'specs_place_id' => $specsPlace['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('option_places')->insert($optionPlaces);
            });
    }
}
