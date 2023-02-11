<?php

namespace App\Http\Controllers\Admin\Place;

use App\Enums\App\MorphTypes;
use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\Place\Place\AddProductRequest;
use App\Http\Requests\Admin\Place\Place\CreateRequest;
use App\Models\Location\Address;
use App\Models\Place\OptionPlace;
use App\Models\Place\Place;
use App\Models\Place\Specs;
use App\Models\Place\SpecsPlace;
use App\Models\Product\Product;
use App\Models\Tag\PlaceTag;
use App\Models\Tag\PlaceTypeTag;
use App\Models\Tag\Tag;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlaceController extends ApiController
{
    use ApiResponse;

    public function __construct(
        protected Place $place,
        protected Specs $specs,
        protected SpecsPlace $specsPlace,
        protected OptionPlace $optionPlace,
        protected Address $address,
        protected Tag $tag,
        protected PlaceTypeTag $placeTypeTag,
        protected PlaceTag $placeTag,
        protected Product $product
    )
    {
    }

    public function create(CreateRequest $request): Response
    {
        $data = $request->validated();
        DB::beginTransaction();
        $placeData = [
            'place_type_id' => $data['place_type_id'],
            'name' => $data['name'],
            'user_id' => $request->user()->id,
            'description' => $data['description'] ?? null,
            'price' => $data['price'] ?? 0,
            'started_at' => $data['started_at'] ?? null,
            'ended_at' => $data['ended_at'] ?? null,
        ];
        $place = $this->place->create($placeData);
        if (!$place) {
            DB::rollBack();
            return $this->operationFailed();
        }
        $status = $this->insertSpecs($request->get('specs', []), $place->id);
        if (!$status) {
            DB::rollBack();
            return $this->operationFailed();
        }
        $status = $this->insertAddress(
            array_merge($request->get('address', []),
                ['addressable_id' => $place->id, 'addressable_type' => MorphTypes::PLACE]
            ));
        if (!$status) {
            DB::rollBack();
            return $this->operationFailed();
        }
        $status = $this->insertTags($request->get('tag', []), $place->id, $place->place_type_id);
        if (!$status) {
            DB::rollBack();
            return $this->operationFailed();
        }
        collect($request->file('images', []))
            ->map(fn($item) => $place->addMedia($item)->toMediaCollection('default')
            );
        DB::commit();
        $placeData = $place->load(['placeTypeTag.tag', 'specs', 'specsPlace.options'])->toArray();
        $placeData['images'] = $place->getMedia('default');
        return $this->operationSucceeded($placeData);
    }

    public function addProduct(AddProductRequest $request, Place $place): Response
    {
        return $this->upsertProduct($request->get('products', []), $place->id, $request)
            ? $this->operationSucceeded() : $this->operationFailed();
    }

    //Helper Method
    private function insertSpecs(array $placeSpec, string $placeId): bool
    {
        $placeSpecsData = [];
        $placeSpecOptionData = [];
        foreach ($placeSpec as $specs) {
            $specsModel = $this->specs->where('id', $specs['id'])->first();
            $placeSpecData = [
                'id' => Str::orderedUuid()->toString(),
                'place_id' => $placeId,
                'specs_id' => $specsModel->id,
                'created_at' => now(),
                'has_multiple_option' => $specsModel->has_multiple_option
            ];
            $placeSpecsData[] = $placeSpecData;
            foreach ($specs['option'] as $optionId) {
                $placeSpecOptionData[] = [
                    'id' => Str::orderedUuid()->toString(),
                    'specs_place_id' => $placeSpecData['id'],
                    'option_id' => $optionId,
                    'created_at' => now(),
                ];
            }
        }
        $status = $this->specsPlace->insert($placeSpecsData);
        if (!$status) {
            return false;
        }
        return (bool)$this->optionPlace->insert($placeSpecOptionData);
    }

    private function insertAddress(array $address): bool
    {
        return (bool)$this->address->create($address);
    }

    private function insertTags(array $tagNames, string $placeId, string $placeTypeId): bool
    {
        if (count($tagNames)) {
            $names = array_map(fn($item) => ['id' => Str::orderedUuid()->toString(), 'name' => $item], $tagNames);
            $status = (bool)$this->tag->query()->upsert($names, ['name']);
            if (!$status) {
                return false;
            }
            $tags = $this->tag->select('id')->whereIn('name', $tagNames)->get()->toArray();
            $toInsertData = collect(array_column($tags, 'id'))->map(function ($tagId) use ($placeTypeId) {
                $newItem['id'] = Str::orderedUuid()->toString();
                $newItem['place_type_id'] = $placeTypeId;
                $newItem['tag_id'] = $tagId;
                $newItem['created_at'] = now();
                $newItem['updated_at'] = now();
                return $newItem;
            })->keyBy('tag_id')->toArray();
            $status = $this->placeTypeTag
                ->upsert($toInsertData, ['place_type_id', 'tag_id']);
            if (!$status) {
                return false;
            }
            $placeTypeTags = $this->placeTypeTag->select('id')->whereIn('tag_id', array_column($tags, 'id'))
                ->where('place_type_id', $placeTypeId)->get()->toArray();
            $toInsertData = collect(array_column($placeTypeTags, 'id'))->map(function ($tagId) use ($placeId) {
                $newItem['id'] = Str::orderedUuid()->toString();
                $newItem['place_id'] = $placeId;
                $newItem['place_type_tag_id'] = $tagId;
                $newItem['created_at'] = now();
                $newItem['updated_at'] = now();
                return $newItem;
            })->keyBy('place_type_tag_id')->toArray();
            $status = $this->placeTag->insert($toInsertData);
            if (!$status) {
                return false;
            }
        }
        return true;
    }

    public function upsertProduct(array $products, string $placeId, AddProductRequest $request): bool
    {

        for ($i = 0, $iMax = count($products); $i < $iMax; $i++) {
            $data[] = [
                'id' => Str::orderedUuid()->toString(),
                'place_id' => $placeId,
                'product_type_id' => $products[$i]['type_id'],
                'name' => $products[$i]['name'],
                'price' => $products[$i]['price']
            ];
            $status = $this->product->query()->updateOrCreate(['product_type_id' => $products[$i]['type_id'], 'place_id' => $placeId], [
                'place_id' => $placeId,
                'product_type_id' => $products[$i]['type_id'],
                'name' => $products[$i]['name'],
                'price' => $products[$i]['price']
            ]);
            if (!$status) {
                return false;
            }
            $productObject = $this->product->query()->where(['product_type_id' => $products[$i]['type_id'], 'place_id' => $placeId])->first();
            $productObject?->addMedia($request->file("products.$i.img"))->toMediaCollection('default');
            return true;
        }
    }
}
