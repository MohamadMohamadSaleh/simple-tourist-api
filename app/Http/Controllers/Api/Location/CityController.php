<?php

namespace App\Http\Controllers\Api\Location;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Models\Location\City;
use App\Models\Location\Country;
use Illuminate\Http\Response;

class CityController extends ApiController
{
    use ApiResponse;

    public function __construct(protected City $city)
    {
    }

    public function index(Country $country): Response
    {
        $cities = $this->city
            ->where('country_id', $country->id)
            ->with('media')
            ->get();
        return $cities ?
            $this->operationSucceeded($cities) :
            $this->authenticationFailed();
    }

    public function show(Country $country, City $city): Response
    {
        return $this->operationSucceeded($city->load('media'));
    }
}
