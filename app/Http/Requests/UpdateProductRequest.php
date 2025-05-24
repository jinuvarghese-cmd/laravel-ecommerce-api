<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Updated name of the product.',
                'example' => 'Gaming Mouse',
            ],
            'description' => [
                'description' => 'Updated product description.',
                'example' => 'Wireless gaming mouse with RGB lighting.',
            ],
            'price' => [
                'description' => 'Updated price.',
                'example' => 49.99,
            ],
            'stock' => [
                'description' => 'Updated stock quantity.',
                'example' => 25,
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
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
            ];
    }
}
