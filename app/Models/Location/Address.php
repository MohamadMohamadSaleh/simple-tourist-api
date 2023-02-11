<?php

namespace App\Models\Location;

use App\Enums\Location\LocationTypes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{

    use Uuid, HasFactory, SoftDeletes;

    protected $table='addresses';

    protected $fillable = [
        'city_id',
        'address',
        'longitude',
        'latitude',
        'postal_code',
        'is_default',
        'addressable_id',
        'addressable_type',
        'street_address'
    ];

    protected $casts = [
        'longitude' => 'double',
        'latitude' => 'double',
    ];

    protected $enumCasts = [
        'type' => LocationTypes::class
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
