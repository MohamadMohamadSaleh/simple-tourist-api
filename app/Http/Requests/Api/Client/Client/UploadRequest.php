<?php

namespace App\Http\Requests\Api\Client\Client;

use App\Enums\App\FileTypes;
use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
            'file' => [
                'required', 'file', 'max:4096',
                'mimes:' . implode(',', FileTypes::getValues())
            ]
        ];
    }
}
