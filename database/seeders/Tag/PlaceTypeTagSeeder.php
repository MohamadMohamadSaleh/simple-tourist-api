<?php

namespace Database\Seeders\Tag;

use App\Models\Place\PlaceType;
use App\Models\Tag\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlaceTypeTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('place_type_tags')->truncate();
        $names = ['أطلال أثرية', 'مواقع تاريخية', 'اثار وتماثيل'];
        $type = PlaceType::where('name', '=', 'أماكن أثرية')->first();
        $tags = Tag::whereIn('name', $names)
            ->get();
        $placeTypeTags = [];
        foreach ($tags as $tag) {
            $placeTypeTags[] = [
                    'id' => Str::orderedUuid()->toString(),
                    'place_type_id' => $type->id,
                    'tag_id' =>$tag['id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
        }
        $names = ['الشرق أوسطية', 'بارد'];
        $type = PlaceType::where('name', '=', 'مطاعم')->first();
        $tags = Tag::whereIn('name', $names)
            ->get();
        foreach ($tags as $tag) {
            $placeTypeTags[] = [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type->id,
                'tag_id' =>$tag['id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        $names = ['قصور', 'مسبح'];
        $type = PlaceType::where('name', '=', 'فنادق')->first();
        $tags = Tag::whereIn('name', $names)
            ->get();
        foreach ($tags as $tag) {
            $placeTypeTags[] = [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type->id,
                'tag_id' =>$tag['id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('place_type_tags')->insert($placeTypeTags);
    }
}
