<?php

namespace App\Services;

use App\Models\Order;

class WebhookService
{
    public function processPayment(array $data): array
    {
        $order = Order::find($data['order_id']);

        if (!$order) {
            return ['status' => 'error', 'message' => 'Order not found', 'code' => 404];
        }

        if ($order->status !== 'pending') {
            return ['status' => 'error', 'message' => 'Order already processed or cancelled', 'code' => 400];
        }

        $order->status = $data['payment_status'] === 'success' ? 'completed' : 'failed';
        $order->payment_reference_id = $data['payment_reference_id'] ?? null;
        $order->paid_at = $data['paid_at'] ?? now();
        $order->save();

        return ['status' => 'success', 'message' => 'Payment processed successfully'];
    }
}
