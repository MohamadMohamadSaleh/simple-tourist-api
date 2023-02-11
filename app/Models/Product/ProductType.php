<?php

namespace App\Models\Product;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'product_types';

    protected $fillable = [
        'name',
        'place_type_id',
    ];
}
