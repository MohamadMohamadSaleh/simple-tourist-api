<?php

namespace Database\Seeders\Tag;

use App\Models\Place\Place;
use App\Models\Place\PlaceType;
use App\Models\Tag\PlaceTypeTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlaceTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('place_tags')->truncate();
        $type = PlaceType::select(['id'])->where('name', '=', 'أماكن أثرية')->first();
        $places = Place::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->toArray();
        PlaceTypeTag::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->each(function ($PlaceTypeTag) use ($places) {
                $placeTags = [];
                foreach ($places as $place) {
                    $placeTags[] = [
                        'id' => Str::orderedUuid()->toString(),
                        'place_type_tag_id' => $PlaceTypeTag->id,
                        'place_id' =>$place['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('place_tags')->insert($placeTags);
            });
        $type = PlaceType::select(['id'])->where('name', '=', 'مطاعم')->first();
        $places = Place::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->toArray();
        PlaceTypeTag::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->each(function ($placeTypeTag) use ($places) {
                $placeTags = [];
                foreach ($places as $place) {
                    $placeTags[] = [
                        'id' => Str::orderedUuid()->toString(),
                        'place_type_tag_id' => $placeTypeTag->id,
                        'place_id' =>$place['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('place_tags')->insert($placeTags);
            });
        $type = PlaceType::select(['id'])->where('name', '=', 'فنادق')->first();
        $places = Place::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->toArray();
        PlaceTypeTag::select(['id'])->where('place_type_id', $type->id)
            ->get()
            ->each(function ($PlaceTypeTag) use ($places) {
                $placeTags = [];
                foreach ($places as $place) {
                    $placeTags[] = [
                        'id' => Str::orderedUuid()->toString(),
                        'place_type_tag_id' => $PlaceTypeTag->id,
                        'place_id' =>$place['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('place_tags')->insert($placeTags);
            });
    }
}
