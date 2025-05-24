<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HandlePaymentRequest extends FormRequest
{
    public function bodyParameters()
    {
        return [
            'order_id' => [
                'description' => 'The ID of the order being paid.',
                'example' => 12,
            ],
            'payment_status' => [
                'description' => 'Status of the payment (e.g., success, failed).',
                'example' => 'success',
            ],
            'payment_reference_id' => [
                'description' => 'The payment reference from the gateway.',
                'example' => 'txn_8jdfg9sdfg',
            ],
            'paid_at' => [
                'description' => 'The timestamp when the payment was made.',
                'example' => '2025-05-24T14:52:00Z',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|integer|exists:orders,id',
            'payment_status' => 'required|in:success,failed',
            'payment_reference_id' => 'nullable|string',
            'paid_at' => 'nullable|date',
        ];
    }
}
