<?php

namespace App\Http\Controllers\Api\Place;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Models\Place\Specs;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SpecController extends ApiController
{
    use ApiResponse;

    public function __construct(
        protected Specs $specs,
    )
    {
    }

    public function index(): Response
    {
        return $this->operationSucceeded(QueryBuilder::for($this->specs)->allowedFilters([AllowedFilter::exact('place_type_id')])->with('options')->get());
    }
}
