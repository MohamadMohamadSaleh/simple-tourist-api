<?php

namespace App\Http\Controllers\Api\Place;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Models\Place\Place;
use App\Models\Product\Product;
use Illuminate\Http\Response;

class ProductController extends ApiController
{
    use ApiResponse;

    public function __construct(protected Product $product)
    {
    }

    public function index(): Response
    {
        return $this->operationSucceeded($this->product->with(['productType', 'place'])->paginate());
    }
}
