<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'email' => 'required|email|min:5',
            'password' => 'min:8|required_with: password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ];
    }

    public function messages()
    {
        return ['email.min' => 'There must be at least five characters in your email'];
    }
}
