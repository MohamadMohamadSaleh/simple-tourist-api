<?php

namespace App\Models\Journey;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JourneyCategory extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'journey_categories';

    protected $fillable = [
        'name'
    ];
}
