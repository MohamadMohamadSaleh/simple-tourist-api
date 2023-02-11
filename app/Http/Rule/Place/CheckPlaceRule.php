<?php

namespace App\Http\Rule\Place;

use App\Models\Place\Option;
use App\Models\Place\Specs;
use Illuminate\Contracts\Validation\Rule;

class CheckPlaceRule implements Rule
{
    public string $massage = '';

    public function __construct(protected ?string $placeTypeId)
    {
    }

    public function passes($attribute, $value)
    {
        $specsValues = collect($value ?? []);
        if (!count($specsValues)) {
            return false;
        }
        $specsIds = array_column($value, 'id');
        $checkIsAllSpecsBelongsToType = Specs::whereIn('id', $specsIds)
            ->where('place_type_id', $this->placeTypeId)
            ->get()
            ->count();
        if (count($specsIds) !== $checkIsAllSpecsBelongsToType) {
            $this->massage = 'the one or more specs does not belongs to this type';
            return false;
        }
        foreach ($specsValues as $specsValue) {
            $optionIds = $specsValue['option'];
            $checkIsAllOptionBelongsToSpecs = Option::whereIn('id', $optionIds)
                ->where('specs_id', $specsValue['id'])
                ->get()
                ->count();
            if (count($optionIds) !== $checkIsAllOptionBelongsToSpecs) {
                $this->massage = 'the one or more options does not belongs to this specs';
                return false;
            }
        }
        return true;
    }

    public function message()
    {
        return $this->massage;
    }
}
