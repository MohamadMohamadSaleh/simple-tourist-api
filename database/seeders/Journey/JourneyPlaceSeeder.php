<?php

namespace Database\Seeders\Journey;

use App\Enums\Journey\JourneyTypes;
use App\Models\Journey\Journey;
use App\Models\Journey\JourneyCategory;
use App\Models\Journey\JourneyStation;
use App\Models\Place\Place;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JourneyPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('journey_places')->truncate();
        $data = [
            [
                'id' => Str::orderedUuid()->toString(),
                'journey_station_id' => (new JourneyStation())->select(['id'])->where('name', 'محطة حلب في الرخلة التاريخية')->first()->id,
                'place_id' => (new Place())->select(['id'])->where('name', 'قلعة حلب')->first()->id,
                'started_at' => now(),
                'ended_at' => now()->addWeek(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'journey_station_id' => (new JourneyStation())->select(['id'])->where('name', 'محطة حلب في الرخلة التاريخية')->first()->id,
                'place_id' => (new Place())->select(['id'])->where('name', 'قلعة سمعان')->first()->id,
                'started_at' => now()->addWeek(),
                'ended_at' => now()->addWeeks(4),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'journey_station_id' => (new JourneyStation())->select(['id'])->where('name', 'محطة حلب في الرخلة التاريخية')->first()->id,
                'place_id' => (new Place())->select(['id'])->where('name', 'مطعم بيرويا')->first()->id,
                'started_at' => now(),
                'ended_at' => now()->addWeek(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'journey_station_id' => (new JourneyStation())->select(['id'])->where('name', 'محطة حلب في رحلة أفضل المطاعم في سوريا')->first()->id,
                'place_id' => (new Place())->select(['id'])->where('name', 'مطعم القمة')->first()->id,
                'started_at' => now()->addWeek(),
                'ended_at' => now()->addWeeks(4),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('journey_places')->insert($data);
    }
}
