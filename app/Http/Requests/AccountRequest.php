<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ];

    }
    public function messages():array{
        return[
            'name.required'=>'name is required',
            'email.required'=>'email is required',
            'email.email'=>'invalid email',
            'email.unique'=>'email already taken',
            'password.required'=>'password is required'
        ];
    }
}
