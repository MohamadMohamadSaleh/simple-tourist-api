<?php

namespace App\Models\Place;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specs extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'specs';

    protected $fillable = [
        'name',
        'place_type_id',
        'has_multiple_option'
    ];

    protected $casts = [
        'has_multiple_option' => 'boolean',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
