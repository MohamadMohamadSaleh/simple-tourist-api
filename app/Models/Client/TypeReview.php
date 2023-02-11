<?php

namespace App\Models\Client;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeReview extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected  $table = 'type_reviews';

    protected  $fillable = [
        'user_id',
        'reviewable_id',
        'reviewable_type',
        'review',
        'comment'
    ];

    protected $casts = [
        'review' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }
}
