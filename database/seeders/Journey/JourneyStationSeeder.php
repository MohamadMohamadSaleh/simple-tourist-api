<?php

namespace Database\Seeders\Journey;

use App\Models\Journey\Journey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JourneyStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('journey_stations')->truncate();
        $data = [
            [
                'id' => Str::orderedUuid()->toString(),
                'journey_id' => (new Journey())->select(['id'])->where('name', 'تاريخية')->first()->id,
                'city_id' => 1,
                'name' => 'محطة حلب في الرخلة التاريخية',
                'order' => 1,
                'started_at' => now(),
                'ended_at' => now()->addWeeks(4),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'journey_id' => (new Journey())->select(['id'])->where('name', 'أفضل المطاعم في سوريا')->first()->id,
                'city_id' => 1,
                'name' => 'محطة حلب في رحلة أفضل المطاعم في سوريا',
                'order' => 1,
                'started_at' => now(),
                'ended_at' => now()->addWeeks(4),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('journey_stations')->insert($data);
    }
}
