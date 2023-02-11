<?php

namespace App\Http\Controllers\Api\Place;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Models\Tag\Tag;
use Illuminate\Http\Response;

class TagController extends ApiController
{
    use ApiResponse;

    public function __construct(
        protected Tag $tag,
    ) {
    }

    public function index(): Response
    {
        return $this->operationSucceeded($this->tag->get());
    }
}
