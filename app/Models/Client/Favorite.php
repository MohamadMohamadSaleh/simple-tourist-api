<?php

namespace App\Models\Client;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'favorable_id',
        'favorable_type'
    ];

    public function favorable(): MorphTo
    {
        return $this->morphTo();
    }
}
