<?php

namespace Database\Seeders\Location;

use App\Enums\App\MorphTypes;
use App\Models\Place\Place;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addresses')->truncate();

        $addresses = [
            [
                'id' => Str::orderedUuid()->toString(),
                'city_id' => 1,
                'addressable_id' => Place::select(['id'])->where('name', 'قلعة حلب')->first()['id'],
                'addressable_type' => MorphTypes::PLACE,
                'address' => 'وسط حلب القديمة',
                'street_address' => 'شارح حول القلعة',
                'longitude' => '36.1996656',
                'latitude' => '37.1626141',
                'postal_code' => '55X7+Q5W',
                'is_default' => false
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'city_id' => 1,
                'addressable_id' => Place::select(['id'])->where('name', 'قلعة سمعان')->first()['id'],
                'addressable_type' => MorphTypes::PLACE,
                'address' => 'دير سمعان',
                'street_address' => null,
                'longitude' => '36.3340117',
                'latitude' => '36.8444893',
                'postal_code' => '8RMV+HPV',
                'is_default' => false
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'city_id' => 1,
                'addressable_id' => Place::select(['id'])->where('name', 'جامع الأموي الكبير')->first()['id'],
                'addressable_type' => MorphTypes::PLACE,
                'address' => 'شارح حول القلعة',
                'street_address' => 'شارح حول القلعة',
                'longitude' => '36.1994711',
                'latitude' => '37.1591535',
                'postal_code' => '55X4+PP8',
                'is_default' => false
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'city_id' => 1,
                'addressable_id' => Place::select(['id'])->where('name', 'مطعم بيرويا')->first()['id'],
                'addressable_type' => MorphTypes::PLACE,
                'address' => 'شارح حول القلعة',
                'street_address' => 'شارح حول القلعة',
                'longitude' => '36.2010454',
                'latitude' => '37.1652159',
                'postal_code' => '6527+C66',
                'is_default' => false
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'city_id' => 1,
                'addressable_id' => Place::select(['id'])->where('name', 'مطعم القمة')->first()['id'],
                'addressable_type' => MorphTypes::PLACE,
                'address' => 'ساعة باب الفرج',
                'street_address' => 'شارع باب الفرج',
                'longitude' => '36.2041678',
                'latitude' => '37.1566291',
                'postal_code' => null,
                'is_default' => false
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'city_id' => 1,
                'addressable_id' => Place::select(['id'])->where('name', 'فندق شيرتون')->first()['id'],
                'addressable_type' => MorphTypes::PLACE,
                'address' => 'ساعة باب الفرج',
                'street_address' => 'شارع باب الفرج',
                'longitude' => '36.2051176',
                'latitude' => '37.1556444',
                'postal_code' => '6543+29W',
                'is_default' => false
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'city_id' => 1,
                'addressable_id' => Place::select(['id'])->where('name', 'فندق البارون')->first()['id'],
                'addressable_type' => MorphTypes::PLACE,
                'address' => 'متحف حلب الوظني',
                'street_address' => 'شارع بارون',
                'longitude' => '36.205115',
                'latitude' => '37.1521358',
                'postal_code' => null,
                'is_default' => false
            ],
        ];
        DB::table('addresses')->insert($addresses);
    }
}
