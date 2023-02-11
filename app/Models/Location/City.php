<?php

namespace App\Models\Location;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class City extends Model implements HasMedia
{
    use Uuid, HasFactory, InteractsWithMedia;

    protected $table = 'cities';

    protected $fillable = [
        'country_id',
        'name',
        'code',
        'longitude',
        'latitude',
    ];

    protected $casts = [
        'country_id' => 'integer',
        'longitude' => 'double',
        'latitude' => 'double',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
