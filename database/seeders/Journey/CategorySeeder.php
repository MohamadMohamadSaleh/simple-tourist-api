<?php

namespace Database\Seeders\Journey;

use App\Models\Place\Specs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('journey_categories')->truncate();
        $data=[
            [
                'id' => Str::orderedUuid()->toString(),
                'name' => 'مغامرات',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'name' => 'ترفيه',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'name' => 'تاريخ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'name' => 'تجربة جديدة',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'name' => 'أفخم المطاعم',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('journey_categories')->insert($data);
    }
}
