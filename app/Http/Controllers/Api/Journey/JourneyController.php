<?php

namespace App\Http\Controllers\Api\Journey;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Models\Journey\Journey;
use Illuminate\Http\Response;

class JourneyController extends ApiController
{
    use ApiResponse;

    public function __construct(protected Journey $journey)
    {
    }

    public function index(): Response
    {
        try {
            return $this->operationSucceeded($this->journey->getAllJourneys());
        } catch (\Error $error) {
            return $this->operationFailed();
        }
    }
}
