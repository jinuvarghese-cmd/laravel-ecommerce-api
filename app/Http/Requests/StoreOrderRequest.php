<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function bodyParameters()
    {
        return [
            'items' => [
                'description' => 'List of products to order.',
                'example' => [
                    ['product_id' => 1, 'quantity' => 2],
                    ['product_id' => 3, 'quantity' => 1],
                ],
            ],
            'items[].product_id' => [
                'description' => 'The ID of the product.',
                'example' => 1,
            ],
            'items[].quantity' => [
                'description' => 'The quantity of the product to order.',
                'example' => 2,
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
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
