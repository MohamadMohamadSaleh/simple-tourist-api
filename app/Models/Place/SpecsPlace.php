<?php

namespace App\Models\Place;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecsPlace extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'specs_places';

    protected $fillable = [
        'specs_id',
        'place_id',
        'has_multiple_option'
    ];

    protected $casts = [
        'has_multiple_option' => 'boolean',
    ];

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'option_places');
    }
}
