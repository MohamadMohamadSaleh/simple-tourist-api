<?php

namespace App\Models\Product;

use App\Models\Place\Place;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use Uuid, HasFactory, SoftDeletes, InteractsWithMedia;

    protected $with = ['media'];

    protected $table = 'products';

    protected $fillable = [
        'place_id',
        'product_type_id',
        'name',
        'price'
    ];
    protected $casts = [
        'price' => 'double'
    ];
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}
