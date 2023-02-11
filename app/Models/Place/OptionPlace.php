<?php

namespace App\Models\Place;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionPlace extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'option_places';

    protected $fillable = [
        'option_id',
        'specs_place_id'
    ];
}
