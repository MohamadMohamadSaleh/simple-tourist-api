<?php

namespace App\Http\Requests\Admin\Place\Place;

use App\Enums\App\FileTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'products_ids' => array_column($this->get('products', []), 'type_id') ?? []
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
            'products' => ['required', 'array', 'min:1', 'max:10'],
            'products.*.type_id' => ['required', 'uuid'],
            'products.*.name' => ['required', 'string'],
            'products.*.price' => ['required', 'min:0', 'max:9999999'],
            'products.*.img' => ['required', 'file', 'max:4096', 'mimes:' . implode(',', FileTypes::getValues())],
            'products_ids' => ['required', Rule::exists('product_types', 'id')
                ->where('place_type_id', $this->route('place')->place_type_id)
                ->withoutTrashed()]
        ];
    }

}
