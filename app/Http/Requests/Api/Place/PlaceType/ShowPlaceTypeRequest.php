<?php

namespace App\Http\Requests\Api\Place\PlaceType;

use Illuminate\Foundation\Http\FormRequest;

class ShowPlaceTypeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'with_tags' => ['nullable', 'boolean'],
            'with_specs' => ['nullable', 'boolean'],
            'with_product_types' => ['nullable', 'boolean'],
        ];
    }

}
