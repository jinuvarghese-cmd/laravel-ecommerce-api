<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Full name of the user.',
                'example' => 'John Doe',
            ],
            'email' => [
                'description' => 'User\'s email address.',
                'example' => 'john@example.com',
            ],
            'password' => [
                'description' => 'Account password.',
                'example' => 'password123',
            ],
            'password_confirmation' => [
                'description' => 'Password confirmation (should match password).',
                'example' => 'password123',
            ],
        ];
    }


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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ];
    }
}
