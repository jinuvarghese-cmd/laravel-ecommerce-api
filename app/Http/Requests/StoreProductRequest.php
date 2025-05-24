<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Name of the product.',
                'example' => 'Laptop',
            ],
            'description' => [
                'description' => 'Optional product description.',
                'example' => 'Fast gaming laptop with RTX 4060.',
            ],
            'price' => [
                'description' => 'Price of the product.',
                'example' => 999.99,
            ],
            'stock' => [
                'description' => 'Quantity of product in stock.',
                'example' => 10,
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
