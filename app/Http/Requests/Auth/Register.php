<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class Register extends FormRequest
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
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'firstName.required' => "First Name is Required",
            'lastName.required' => "Last Name is Required",
            'email.required' => "Email is required",
            "email.unique" => "This email already exist",
            "password.required" => "Password is required",
            "password.min" => "Password must be grater than 6 character"
        ];
    }

}
