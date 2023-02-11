<?php

namespace Database\Seeders\Place;

use App\Enums\App\MorphTypes;
use App\Models\Client\User;
use App\Models\Place\Place;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_reviews')->truncate();
        $places = Place::query()->get(['id'])->toArray();
        $reviews = [];
        foreach (User::all()->toArray() as $user) {
            $reviews[] = [
                'id' => Str::orderedUuid()->toString(),
                'user_id' => $user['id'],
                'reviewable_id' => $places[random_int(0, count($places) - 1)]['id'],
                'reviewable_type' => MorphTypes::PLACE,
                'review' => random_int(1, 5),
            ];
        }
        DB::table('type_reviews')->insert($reviews);
    }
}
