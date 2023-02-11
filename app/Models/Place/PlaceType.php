<?php

namespace App\Models\Place;

use App\Models\Product\ProductType;
use App\Models\Tag\Tag;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PlaceType extends Model implements HasMedia
{
    use Uuid, HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'place_types';

    protected $with = ['media'];

    protected $fillable = [
        'name'
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'place_type_tags');
    }

    public function specs(): HasMany
    {
        return $this->hasMany(Specs::class);
    }

    public function productTypes(): HasMany
    {
        return $this->hasMany(ProductType::class);
    }
}
