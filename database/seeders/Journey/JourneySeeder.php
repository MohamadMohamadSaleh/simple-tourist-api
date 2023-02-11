<?php

namespace Database\Seeders\Journey;

use App\Enums\Journey\JourneyTypes;
use App\Models\Journey\JourneyCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JourneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('journeys')->truncate();
        $data = [
            [
                'id' => Str::orderedUuid()->toString(),
                'journey_category_id' => (new JourneyCategory())->select(['id'])->where('name', 'تاريخ')->first()->id,
                'name' => 'تاريخية',
                'description' => 'زيارة تاريخية الى آثار سوريا حيث يتم التعرف في هذه الرحلة علي أبرز الأثار التاريخية الموجودة في سورية',
                'max' => 10,
                'cost' => 50000,
                'type' => JourneyTypes::PUBLIC_JOURNEY,
                'started_at' => now(),
                'ended_at' => now()->addWeeks(4),
                'number_of_days' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'journey_category_id' => (new JourneyCategory())->select(['id'])->where('name', 'أفخم المطاعم')->first()->id,
                'name' => 'أفضل المطاعم في سوريا',
                'description' => 'زيارة مطاعم وتذوق أفضل الوجبات في سوريا',
                'max' => 20,
                'cost' => 100000,
                'type' => JourneyTypes::PUBLIC_JOURNEY,
                'started_at' => now(),
                'ended_at' => now()->addWeeks(4),
                'number_of_days' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('journeys')->insert($data);
    }
}
