<?php

namespace App\Http\Requests\Api\Client\Client;

use App\Enums\App\MorphTypes;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class AddFavoriteRequest extends FormRequest
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
            'favorable_id' => ['required', 'uuid'],
            'favorable_type' => ['required', new EnumValue(MorphTypes::class)]
        ];
    }
}
