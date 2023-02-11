<?php

namespace App\Http\Controllers\Api\Location;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Models\Location\Country;
use Illuminate\Http\Response;

class CountryController extends ApiController
{
    use ApiResponse;

    public function __construct(protected Country $country)
    {
    }

    public function index(): Response
    {
        $countries = $this->country
            ->get();
        return $countries ?
            $this->operationSucceeded($countries) :
            $this->authenticationFailed();
    }

    public function show(Country $country): Response
    {
        return $this->operationSucceeded($country);
    }
}
