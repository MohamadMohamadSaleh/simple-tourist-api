<?php

namespace App\Http\Requests\Api\Client\Client;

use App\Enums\App\MorphTypes;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
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
            'reviewable_id' => ['required', 'uuid'],
            'reviewable_type' => ['required', new EnumValue(MorphTypes::class)],
            'review' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string']
        ];
    }
}
