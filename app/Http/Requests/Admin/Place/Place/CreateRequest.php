<?php

namespace App\Http\Requests\Admin\Place\Place;

use App\Enums\App\FileTypes;
use App\Http\Rule\Place\CheckPlaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'tags' => $this->collect('tags')->each(function ($item) {
                return Str::snake(trim($item));
            })->toArray(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:2', 'string', Rule::unique('places', 'name')->withoutTrashed()],
            'place_type_id' => ['required', 'uuid', Rule::exists('place_types', 'id')->withoutTrashed()],
            'description' => ['nullable', 'string'],
            'price' => ['numeric', 'min:1'],
            'started_at' => ['nullable', 'date_format:Y-m-d H:i', 'after:now'],
            'ended_at' => ['nullable', 'date_format:Y-m-d H:i', 'after:started_at'],
            'address.address' => ['required', 'string', 'min:2', 'max:100'],
            'address.longitude' => ['nullable', 'numeric'],
            'address.latitude' => ['nullable', 'numeric'],
            'address.postal_code' => ['nullable', 'string'],
            'address.city_id' => ['required', 'integer', Rule::exists('cities', 'id')],
            'specs' => ['array', new CheckPlaceRule($this->get('place_type_id'))],
            'specs.*.id' => ['required', 'uuid'],
            'specs.*.option' => ['required', 'array'],
            'specs.*.option.*' => ['required', 'uuid'],
            'images' => ['nullable', 'array'],
            'images.*' => [
                'required', 'file', 'max:4096', 'mimes:' . implode(',', FileTypes::getValues())
            ],
            'tags' => ['array', 'max:25', 'distinct'],
            'tags.*' => ['string', 'max:30', 'min:3'],
        ];
    }

}
