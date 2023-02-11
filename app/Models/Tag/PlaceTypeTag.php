<?php

namespace App\Models\Tag;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceTypeTag extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'place_type_tags';

    protected $fillable = [
        'tag_id',
        'place_type_id',
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
