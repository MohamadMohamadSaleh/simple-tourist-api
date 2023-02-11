<?php

namespace App\Http\Requests\Api\Client\Client;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password'=>['required','min:4','max:16'],
            'password' => ['required','min:4','max:16', 'confirmed'],
        ];
    }
}
