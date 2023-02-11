<?php

namespace App\Http\Controllers\Api\Place;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Place\PlaceType\ShowPlaceTypeRequest;
use App\Models\Place\PlaceType;
use App\Models\Tag\PlaceTypeTag;
use Illuminate\Http\Response;

class PlaceTypeController extends ApiController
{
    use ApiResponse;

    public function __construct(
        protected PlaceType $placeType,
    ) {
    }

    public function index(): Response
    {
        return $this->operationSucceeded($this->placeType->with('media')->get());
    }

    public function show(ShowPlaceTypeRequest $request, PlaceType $type): Response
    {
        if ($request->with_tags) {
            $type->load('tags');
        }
        if ($request->with_specs) {
            $type->load(['specs', 'specs.options']);
        }
        if ($request->with_product_types) {
            $type->load(['productType']);
        }
        return $this->operationSucceeded($type);
    }
}
