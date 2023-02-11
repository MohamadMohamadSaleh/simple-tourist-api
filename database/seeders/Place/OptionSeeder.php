<?php

namespace Database\Seeders\Place;

use App\Models\Place\Specs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->truncate();
        $specs[] = Specs::select(['id'])->where('name', '=', 'الأطباق')->first();
        $specs[] = Specs::select(['id'])->where('name', '=', 'الوجبات')->first();
        $specs[] = Specs::select(['id'])->where('name', '=', 'عدد الغرف')->first();
        $specs[] = Specs::select(['id'])->where('name', '=', 'ميزات الغرف')->first();
        $options = [
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[0]['id'],
                'name' => 'اسيوي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[0]['id'],
                'name' => 'شرقي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[0]['id'],
                'name' => 'غربي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[1]['id'],
                'name' => 'غذاء',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[1]['id'],
                'name' => 'عشاء',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[1]['id'],
                'name' => 'أفطار',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[2]['id'],
                'name' => 'غرقة واحدة',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[2]['id'],
                'name' => 'تلات غرف',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[3]['id'],
                'name' => 'نت  مجاني',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[3]['id'],
                'name' => 'مسبح',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[3]['id'],
                'name' => 'أكل مجاني',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'specs_id' => $specs[3]['id'],
                'name' => 'مناسبة للاطفال',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('options')->insert($options);
    }
}
