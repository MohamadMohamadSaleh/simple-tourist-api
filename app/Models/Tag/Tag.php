<?php

namespace App\Models\Tag;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'tags';

    protected $fillable = [
        'name'
    ];
}
