<?php

namespace App\Http\Controllers\Api\Journey;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Models\Journey\JourneyCategory;
use Illuminate\Http\Response;

class CategoryController extends ApiController
{
    use ApiResponse;

    public function __construct(protected JourneyCategory $category)
    {
    }

    public function index(): Response
    {
        return $this->operationSucceeded($this->category->get(['id', 'name']));
    }
}
