<?php

namespace App\Models\Place;

use App\Enums\App\MorphTypes;
use App\Models\Client\Favorite;
use App\Models\Client\TypeReview;
use App\Models\Location\Address;
use App\Models\Product\Product;
use App\Models\Product\ProductType;
use App\Models\Tag\PlaceTypeTag;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Place extends Model implements HasMedia
{
    use Uuid, HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'places';

    protected $with = ['media'];

    protected $fillable = [
        'name',
        'user_id',
        'place_type_id',
        'description',
        'price',
        'started_at',
        'ended_at'
    ];

    protected $dates = [
        'started_at',
        'ended_at'
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function placeType(): BelongsTo
    {
        return $this->belongsTo(PlaceType::class, 'place_type_id');
    }

    public function placeTypeTag(): BelongsToMany
    {
        return $this->belongsToMany(
            PlaceTypeTag::class,
            'place_tags'
        )->with('tag');
    }

    public function productTypes(): BelongsToMany
    {
        return $this->belongsToMany(ProductType::class, 'products');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'place_id')->with('productType');
    }

    public function specs(): BelongsToMany
    {
        return $this->belongsToMany(Specs::class, 'specs_places');
    }

    public function specsPlace(): HasMany
    {
        return $this->hasMany(SpecsPlace::class, 'place_id')->with('options');
    }

    public function favoritesRelation(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(TypeReview::class, 'reviewable');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function getAllPlaces()
    {
        $userId = Auth::guard('api')->user()?->id;
        return QueryBuilder::for($this)
            ->select([
                'places.id as id',
                'places.name as name',
                'places.place_type_id as place_type_id',
                'place_types.name as place_type',
                'addresses.address as address',
                'addresses.street_address as street_address',
                'cities.name as city',
                'countries.name as country',
                DB::raw('COUNT(type_reviews.id)  as  comment'),
                DB::raw('(SUM(type_reviews.review) DIV COUNT(type_reviews.review))  as review'),
                DB::raw('COUNT(distinct favorites.id)  as favorites'),
            ])
            ->allowedFilters([
                AllowedFilter::exact('place_type_id', 'placeType.id'),
                AllowedFilter::exact('tag_id', 'placeTypeTag.tag.id'),
                AllowedFilter::exact('product_id', 'products.id'),
                AllowedFilter::exact('product_type_id', 'productTypes.id'),
                AllowedFilter::exact('specs_id', 'specs.id'),
                AllowedFilter::exact('city_id', 'cities.id'),
                AllowedFilter::exact('country_id', 'countries.id'),
                AllowedFilter::partial('option_id', 'specsPlace.options.name'),
                AllowedFilter::partial('name', 'places.name'),
                AllowedFilter::partial('place_type', 'placeType.name'),
                AllowedFilter::partial('tag_name', 'placeTypeTag.tag.name'),
                AllowedFilter::partial('product_name', 'products.name'),
                AllowedFilter::exact('product_type_name', 'productTypes.name'),
                AllowedFilter::partial('specs_name', 'specs.name'),
                AllowedFilter::partial('option_name', 'specsPlace.options.name'),
                AllowedFilter::partial('city_name', 'cities.name'),
                AllowedFilter::partial('country_name', 'countries.name'),
                AllowedFilter::callback('review', function (Builder $query, float $review) {
                    $query->where('review', '>=', $review);
                }),
                AllowedFilter::callback('address', function (Builder $query, array $data) {
                    [$latitude, $longitude, $rang] = $data;
                    $query->addSelect(DB::raw("6371 *
                                                    acos(cos(radians($latitude))  *
                                                    cos(radians(addresses.latitude)) *
                                                    cos(radians(addresses.longitude) -
                                                    radians($longitude)) +
                                                    sin(radians($latitude)) *
                                                    sin(radians(addresses.latitude))) AS distance"))
                        ->having('distance', '<', $rang);
                }),
            ])
            ->leftJoin('addresses', function ($address) {
                $address->on('addresses.addressable_id', '=', 'places.id')
                    ->where('addresses.addressable_type', '=', MorphTypes::PLACE)
                    ->join('cities', function ($city) {
                        $city->on('cities.id', '=', 'addresses.city_id')
                            ->join('countries', function ($city) {
                                $city->on('countries.id', '=', 'cities.country_id');
                            });
                    });
            })
            ->join('place_types', 'place_types.id', '=', 'places.place_type_id')
            ->leftJoin('type_reviews', function ($favorites) {
                $favorites->on('places.id', '=', 'type_reviews.reviewable_id')
                    ->whereNull('type_reviews.deleted_at');
            })
            ->leftJoin('favorites', function ($favorites) {
                $favorites->on('places.id', '=', 'favorites.favorable_id')
                    ->whereNull('favorites.deleted_at');
            })
            ->with('favoritesRelation', function ($favorites) use ($userId) {
                $favorites->where('user_id', $userId);
            })
            ->groupBy([
                'places.id',
                'places.name',
                'place_types.name',
                'addresses.address',
                'addresses.street_address',
                'cities.name',
                'countries.name',
                'places.place_type_id'
            ])->paginate();

    }

    public function showPlace(string $placeId)
    {
        return $this->where('places.id', $placeId)
            ->select([
                'addresses.address as address',
                'addresses.street_address as street_address',
                'cities.name as city',
                'countries.name as country',
                DB::raw('COUNT(type_reviews.id)  as  comment'),
                DB::raw('(SUM(type_reviews.review) DIV COUNT(type_reviews.review))  as review'),
                DB::raw('COUNT(favorites.id)  as favorites'),
            ])
            ->leftJoin('addresses', function ($address) {
                $address->on('addresses.addressable_id', '=', 'places.id')
                    ->where('addresses.addressable_type', '=', MorphTypes::PLACE)
                    ->join('cities', function ($city) {
                        $city->on('cities.id', '=', 'addresses.city_id')
                            ->join('countries', function ($city) {
                                $city->on('countries.id', '=', 'cities.country_id');
                            });
                    });
            })
            ->leftJoin('type_reviews', function ($favorites) {
                $favorites->on('places.id', '=', 'type_reviews.reviewable_id')
                    ->whereNull('type_reviews.deleted_at');
            })
            ->leftJoin('favorites', function ($favorites) {
                $favorites->on('places.id', '=', 'favorites.favorable_id')
                    ->whereNull('favorites.deleted_at');
            })
            ->groupBy([
                'addresses.address',
                'addresses.street_address',
                'cities.name',
                'countries.name'
            ])->first();
    }

    public function getAllFavorite()
    {
        $userId = Auth::guard('api')->user()?->id;
        return $this
            ->select([
                'places.id as id',
                'places.name as name',
                'place_types.name as place_type',
                'addresses.address as address',
                'addresses.street_address as street_address',
                'cities.name as city',
                'countries.name as country',
                'places.place_type_id as place_type_id',
                DB::raw('COUNT(type_reviews.review)  as  comment'),
                DB::raw('(SUM(type_reviews.review) DIV COUNT(type_reviews.review))  as review'),
                DB::raw('COUNT(distinct favorites.id)  as favorites'),
            ])
            ->leftJoin('addresses', function ($address) {
                $address->on('addresses.addressable_id', '=', 'places.id')
                    ->where('addresses.addressable_type', '=', MorphTypes::PLACE)
                    ->join('cities', function ($city) {
                        $city->on('cities.id', '=', 'addresses.city_id')
                            ->join('countries', function ($city) {
                                $city->on('countries.id', '=', 'cities.country_id');
                            });
                    });
            })
            ->join('place_types', 'place_types.id', '=', 'places.place_type_id')
            ->leftJoin('type_reviews', function ($favorites) {
                $favorites->on('places.id', '=', 'type_reviews.reviewable_id')
                    ->whereNull('type_reviews.deleted_at');
            })
            ->leftJoin('favorites', function ($favorites) {
                $favorites->on('places.id', '=', 'favorites.favorable_id')
                    ->whereNull('favorites.deleted_at');
            })
            ->whereHas('favoritesRelation', function ($favorites) use ($userId) {
                $favorites->where('user_id', $userId);
            })
            ->groupBy([
                'places.id',
                'places.name',
                'place_types.name',
                'addresses.address',
                'addresses.street_address',
                'cities.name',
                'countries.name',
                'places.place_type_id'
            ])->get();
    }
}
