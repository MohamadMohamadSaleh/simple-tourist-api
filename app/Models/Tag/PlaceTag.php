<?php

namespace App\Models\Tag;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceTag extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'place_tags';

    protected $fillable = [
        'place_id',
        'place_type_tag_id',
    ];
}
