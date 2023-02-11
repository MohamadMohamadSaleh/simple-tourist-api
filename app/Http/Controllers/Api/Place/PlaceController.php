<?php

namespace App\Http\Controllers\Api\Place;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Models\Place\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlaceController extends ApiController
{
    use ApiResponse;

    public function __construct(protected Place $place)
    {
    }

    public function index(): Response
    {
        try {
            return $this->operationSucceeded($this->place->getAllPlaces());
        } catch (\Error $error) {
            return $this->operationFailed();
        }
    }

    public function show(Request $request, Place $place): Response
    {
        $userId = $request->user('api')?->id;
        $placeData = $place->load(['favoritesRelation' => function ($favorites) use ($userId) {
            $favorites->where('user_id', $userId);
        }, 'placeTypeTag.tag', 'specs', 'specsPlace.options', 'products', 'reviews.user'])?->toArray();
        $additionalData = $this->place->showPlace($place->id);
        $placeData['comment'] = $additionalData['comment'];
        $placeData['address'] = $additionalData['address'];
        $placeData['street_address'] = $additionalData['street_address'];
        $placeData['city'] = $additionalData['city'];
        $placeData['country'] = $additionalData['country'];
        $placeData['review'] = $additionalData['review'];
        $placeData['favorites'] = $additionalData['favorites'];
        return $this->operationSucceeded($placeData);
    }
}
