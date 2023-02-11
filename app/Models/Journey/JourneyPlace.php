<?php

namespace App\Models\Journey;

use App\Models\Place\Place;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JourneyPlace extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'journey_places';

    protected $fillable = [
        'journey_station_id',
        'place_id',
        'started_at',
        'ended_at'
    ];

    protected $dates = [
        'started_at',
        'ended_at'
    ];
    protected $casts = [
        'order' => 'integer'
    ];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}
