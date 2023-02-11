<?php

namespace App\Http\Requests\Api\Client\Client;

use App\Enums\Client\GenderTypes;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'min:2'],
            'last_name' =>  ['required', 'string', 'min:2'],
            'gender' => ['required', new EnumValue(GenderTypes::class)],
            'city_id' => ['required', 'int', Rule::exists('cities', 'id')],
            'birthday' => ['nullable','date', 'date_format:Y-m-d']
        ];
    }

}
