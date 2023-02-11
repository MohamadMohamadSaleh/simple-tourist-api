<?php

namespace App\Http\Requests\Admin\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username' => ['required','string'],
            'password' => ['required','string','min:4','max:16']
        ];
    }

}
