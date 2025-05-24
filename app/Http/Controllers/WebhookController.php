<?php

namespace App\Http\Controllers;

use App\Services\WebhookService;
use App\Http\Requests\HandlePaymentRequest;


class WebhookController extends Controller
{
    protected $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

        /**
     * Handle payment gateway webhook
     *
     * @group Webhooks
     *
     * This endpoint receives payment notifications from a payment gateway.
     * It verifies and processes the incoming payment data (e.g. marking an order as paid).
     *
     * @bodyParam order_id integer required ID of the order being paid. Example: 5
     * @bodyParam payment_status string required Status of the payment. Example: success
     * @response 200 {
     *   "message": "Payment processed successfully"
     * }
     */
    public function handlePayment(HandlePaymentRequest $request)
    {
        $result = $this->webhookService->processPayment($request->validated());

        return response()->json(
            ['message' => $result['message']],
            $result['status'] === 'success' ? 200 : ($result['code'] ?? 400)
        );
    }
}
