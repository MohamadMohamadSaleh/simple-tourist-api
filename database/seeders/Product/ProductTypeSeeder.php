<?php

namespace Database\Seeders\Product;

use App\Models\Place\PlaceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->truncate();
        $type[] = PlaceType::select(['id'])->where('name', '=', 'مطاعم')->first();
        $type[] = PlaceType::select(['id'])->where('name', '=', 'فنادق')->first();
        $data=[
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[0]['id'],
                'name' => 'الإفطار',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[0]['id'],
                'name' => 'مقبلات',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[0]['id'],
                'name' => 'مشروبات',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[0]['id'],
                'name' => 'مأكولات غربية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[0]['id'],
                'name' => 'مأكولات شرقية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_type_id' => $type[0]['id'],
                'name' => 'حلويات',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('product_types')->insert($data);
    }
}
