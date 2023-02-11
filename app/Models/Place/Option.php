<?php

namespace App\Models\Place;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'options';

    protected $fillable = [
        'name',
        'specs_id'
    ];
}
