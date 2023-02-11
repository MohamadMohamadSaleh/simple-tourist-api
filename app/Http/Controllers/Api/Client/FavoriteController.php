<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Client\Client\AddFavoriteRequest;
use App\Http\Requests\Api\Client\Client\GetFavoriteRequest;
use App\Http\Requests\Api\Client\Client\RemoveFavoriteRequest;
use App\Models\Client\Favorite;
use App\Models\Journey\Journey;
use App\Models\Place\Place;
use Illuminate\Http\Response;


class FavoriteController extends ApiController
{
    public function __construct(protected Favorite $favorite, protected Place $place, protected Journey $journey)
    {
    }

    public function index(GetFavoriteRequest $request): Response
    {
        return $this->operationSucceeded($this->{$request->get('favorable_type')}->getAllFavorite());
    }

    public function add(AddFavoriteRequest $request): Response
    {
        if (!$this->{$request->get('favorable_type')}->where('id', $request->get('favorable_id'))->exists()) {
            return $this->invalidData();
        }
        $favorite = $this->favorite
            ->query()
            ->where(['favorable_id' => $request->get('favorable_id'), 'favorable_type' => $request->get('favorable_type'), 'user_id' => $request->user()->id])
            ->exists();
        if ($favorite) {
            return $this->alreadyExists();
        }
        $favorite = $this->favorite
            ->query()
            ->create(['favorable_id' => $request->get('favorable_id'), 'favorable_type' => $request->get('favorable_type'), 'user_id' => $request->user()->id]);

        return $favorite ? $this->operationSucceeded($favorite) : $this->operationFailed();
    }

    public function remove(RemoveFavoriteRequest $request): Response
    {
        $status = $this->favorite
            ->query()
            ->where(['favorable_id' => $request->get('favorable_id'), 'user_id' => $request->user()->id])
            ->delete();
        return $status ?
            $this->operationSucceeded() :
            $this->operationFailed();
    }
}
