<?php

namespace App\Http\Controllers\Api\Place;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Models\Place\PlaceType;
use App\Models\Product\ProductType;
use Illuminate\Http\Response;

class ProductTypeController extends ApiController
{
    use ApiResponse;

    public function __construct(protected ProductType $productType)
    {
    }

    public function index(PlaceType $placeType): Response
    {
        return $this->operationSucceeded($this->productType->where('place_type_id', $placeType->id)->get());
    }
}
