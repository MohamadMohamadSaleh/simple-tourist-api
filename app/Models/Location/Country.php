<?php

namespace App\Models\Location;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use Uuid,HasFactory;

    protected $table ='countries';

    protected $fillable = [
        'name',
        'capital',
        'currency_code',
    ];
    protected $casts = [
        'continent_id'=>'integer',
        'has_division'=>'integer',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'country_id');
    }
}
