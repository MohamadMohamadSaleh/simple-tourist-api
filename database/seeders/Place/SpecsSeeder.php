<?php

namespace Database\Seeders\Place;

use App\Models\Place\PlaceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpecsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specs')->truncate();
        $type[] = PlaceType::select(['id'])->where('name', '=', 'مطاعم')->first();
        $type[] = PlaceType::select(['id'])->where('name', '=', 'فنادق')->first();
        $specs=[
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[0]['id'],
                'name' => 'الأطباق',
                'has_multiple_option' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[0]['id'],
                'name' => 'الوجبات',
                'has_multiple_option' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[1]['id'],
                'name' => 'عدد الغرف',
                'has_multiple_option' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[1]['id'],
                'name' => 'ميزات الغرف',
                'has_multiple_option' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('specs')->insert($specs);
    }
}
