<?php

namespace App\Http\Controllers\Api\Client;

use App\Enums\App\MorphTypes;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Client\Client\CreateReviewRequest;
use App\Models\Client\TypeReview;
use App\Models\Journey\Journey;
use App\Models\Place\Place;
use Illuminate\Http\Response;


class ReviewController extends ApiController
{
    public function __construct(protected TypeReview $typeReview, protected Place $place, protected Journey $journey)
    {
    }

    public function updateOrCreate(CreateReviewRequest $request): Response
    {
        if (!$this->{$request->get('reviewable_type')}->where('id', $request->get('reviewable_id'))->exists()) {
            return $this->invalidData();
        }
        $typeReview = $this->typeReview
            ->updateOrCreate(
                ['reviewable_id' => $request->get('reviewable_id'), 'user_id' => $request->user()->id],
                [
                    'reviewable_id' => $request->get('reviewable_id'),
                    'reviewable_type' => $request->get('reviewable_type'),
                    'user_id' => $request->user()->id,
                    'review' => $request->get('review'),
                    'comment' => $request->get('comment'),
                ]
            );
        return $typeReview ? $this->operationSucceeded($this->typeReview->query()->where(['reviewable_id' => $request->get('reviewable_id'), 'user_id' => $request->user()->id])->first()) : $this->operationFailed();
    }
}
