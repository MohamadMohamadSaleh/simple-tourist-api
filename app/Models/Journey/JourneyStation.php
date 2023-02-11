<?php

namespace App\Models\Journey;

use App\Models\Location\City;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JourneyStation extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'journey_stations';

    protected $fillable = [
        'journey_id',
        'city_id',
        'name',
        'order',
        'started_at',
        'ended_at'
    ];

    protected $dates = [
        'started_at',
        'ended_at'
    ];

    public function journeyPlaces(): HasMany
    {
        return $this->hasMany(JourneyPlace::class, 'journey_station_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
