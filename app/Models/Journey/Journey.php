<?php

namespace App\Models\Journey;

use App\Enums\Journey\JourneyTypes;
use App\Enums\Journey\StatusTypes;
use App\Models\Client\Favorite;
use App\Models\Client\TypeReview;
use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Journey extends Model implements HasMedia
{
    use Uuid, HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'journeys';

    protected $fillable = [
        'journey_category_id',
        'name',
        'description',
        'max',
        'number_of_days',
        'note',
        'done',
        'cost',
        'type',
        'status',
        'started_at',
        'ended_at'
    ];

    protected $dates = [
        'started_at',
        'ended_at'
    ];

    protected $casts = [
        'max' => 'integer',
        'cost' => 'integer',
        'number_of_days' => 'integer',
        'done' => 'boolean',
    ];

    protected $enumCasts = [
        'type' => JourneyTypes::class,
        'status' => StatusTypes::class
    ];

    public function favoritesRelation(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JourneyCategory::class, 'journey_category_id');
    }

    public function stations(): HasMany
    {
        return $this->hasMany(JourneyStation::class, 'journey_id');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(TypeReview::class, 'reviewable');
    }

    public function getAllJourneys()
    {
        $userId = Auth::guard('api')->user()?->id;
        return QueryBuilder::for($this)
            ->select([
                'journeys.id as id',
                'journeys.name as name',
                'journeys.description as description',
                'journeys.max as max',
                'journeys.number_of_days as number_of_days',
                'journeys.type as type',
                'journeys.cost as cost',
                'journeys.status as status',
                'journeys.started_at as started_at',
                'journeys.ended_at as ended_at',
                'journey_categories.name as category',
                DB::raw('COUNT(type_reviews.id)  as comment'),
                DB::raw('(SUM(type_reviews.review) DIV COUNT(type_reviews.review))  as review'),
                DB::raw('COUNT(favorites.id)  as favorites'),
            ])->allowedFilters([
                AllowedFilter::exact('journey_id', 'journeys.id'),
                AllowedFilter::exact('journey_type', 'journeys.type'),
                AllowedFilter::exact('category_id', 'category.id'),
                AllowedFilter::exact('station_id', 'stations.id'),
                AllowedFilter::exact('place_id', 'stations.journeyPlaces.place.id'),
                AllowedFilter::exact('city_id', 'stations.city.id'),
                AllowedFilter::partial('journey_name', 'journeys.name'),
                AllowedFilter::partial('category_name', 'category.name'),
                AllowedFilter::partial('station_name', 'stations.name'),
                AllowedFilter::partial('place_name', 'stations.journeyPlaces.place.name'),
                AllowedFilter::partial('city_name', 'stations.city.name'),
                AllowedFilter::callback('review', function (Builder $query, float $review) {
                    $query->where('review', '>=', $review);
                }),
                AllowedFilter::callback('max', function (Builder $query, int $max) {
                    $query->where('journeys.max', '<=', $max);
                }),
                AllowedFilter::callback('number_of_days', function (Builder $query, int $numberOfDays) {
                    $query->where('journeys.number_of_days', '>=', $numberOfDays);
                }),
                AllowedFilter::callback('number_of_days_between', function (Builder $query, int $numberOne, $numberTwo) {
                    $query->whereBetween('journeys.number_of_days', [$numberOne, $numberTwo]);
                }),
                AllowedFilter::callback('starts_before', function (Builder $query, string $date) {
                    $query->where('journeys.started_at', '<=', Carbon::parse($date));
                }),
                AllowedFilter::callback('ends_before', function (Builder $query, string $date) {
                    $query->where('journeys.ended_at', '<=', Carbon::parse($date));
                }),
                AllowedFilter::callback('starts_between', function (Builder $query, array $data) {
                    [$start, $end] = $data;
                    $query->where('journeys.started_at', '>=', Carbon::parse($start))
                        ->where('journeys.started_at', '<=', Carbon::parse($end));
                }),
                AllowedFilter::callback('ends_between', function (Builder $query, array $data) {
                    [$start, $end] = $data;
                    $query->where('journeys.ended_at', '>=', Carbon::parse($start))
                        ->where('journeys.ended_at', '<=', Carbon::parse($end));
                }),
            ])
            ->with(['stations.journeyPlaces.place' => function ($place) {
                $place->with(['address', 'reviews.user', 'media']);
            }, 'reviews.user'])
            ->with('favoritesRelation', function ($favorites) use ($userId) {
                $favorites->where('user_id', $userId);
            })
            ->join('journey_categories', 'journeys.journey_category_id', '=', 'journey_categories.id')
            ->leftJoin('type_reviews', function ($favorites) {
                $favorites->on('journeys.id', '=', 'type_reviews.reviewable_id')
                    ->whereNull('type_reviews.deleted_at');
            })
            ->leftJoin('favorites', function ($favorites) {
                $favorites->on('journeys.id', '=', 'favorites.favorable_id')
                    ->whereNull('favorites.deleted_at');
            })
            ->groupBy([
                'journeys.id',
                'journeys.name',
                'journeys.description',
                'journeys.max',
                'journeys.number_of_days',
                'journeys.type',
                'journeys.cost',
                'journeys.status',
                'journeys.started_at',
                'journeys.ended_at',
                'journey_categories.name'
            ])->paginate();
    }

    public function getAllFavorite()
    {
        $userId = Auth::guard('api')->user()?->id;
        return $this
            ->select([
                'journeys.id as id',
                'journeys.name as name',
                'journeys.description as description',
                'journeys.max as max',
                'journeys.number_of_days as number_of_days',
                'journeys.type as type',
                'journeys.cost as cost',
                'journeys.status as status',
                'journeys.started_at as started_at',
                'journeys.ended_at as ended_at',
                'journey_categories.name as category',
                DB::raw('(SUM(type_reviews.review) DIV COUNT(type_reviews.review))  as review'),
                DB::raw('COUNT(favorites.id)  as favorites'),
            ])
            ->with(['stations.journeyPlaces.place' => function ($place) {
                $place->with(['address', 'reviews.user', 'media']);
            }, 'reviews.user'])
            ->whereHas('favoritesRelation', function ($favorites) use ($userId) {
                $favorites->where('user_id', $userId);
            })
            ->join('journey_categories', 'journeys.journey_category_id', '=', 'journey_categories.id')
            ->leftJoin('type_reviews', function ($favorites) {
                $favorites->on('journeys.id', '=', 'type_reviews.reviewable_id')
                    ->whereNull('type_reviews.deleted_at');
            })
            ->leftJoin('favorites', function ($favorites) {
                $favorites->on('journeys.id', '=', 'favorites.favorable_id')
                    ->whereNull('favorites.deleted_at');
            })
            ->groupBy([
                'journeys.id',
                'journeys.name',
                'journeys.description',
                'journeys.max',
                'journeys.number_of_days',
                'journeys.type',
                'journeys.cost',
                'journeys.status',
                'journeys.started_at',
                'journeys.ended_at',
                'journey_categories.name'
            ])->get();
    }
}
