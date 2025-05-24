<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $service)
    {
        $this->orderService = $service;
    }

    /**
     * Place a new order
     *
     * Place a new order with a list of products and quantities.
     *
     * @group Orders
     * 
     * @authenticated
     * 
     * @bodyParam items array required List of products to order.
     * @bodyParam items[].product_id integer required The ID of the product. Example: 1
     * @bodyParam items[].quantity integer required Quantity of the product. Example: 2
     *
     * @response 200 {
     *   "message": "Order placed successfully",
     *   "order": {
     *     "id": 19,
     *     "user": {
     *       "id": 6,
     *       "name": "Admin",
     *       "email": "admin@admin.com",
     *       "role": "admin"
     *     },
     *     "items": [
     *       {
     *         "product_id": 1,
     *         "name": "Test Product",
     *         "price": "2.00",
     *         "quantity": 7
     *       },
     *       {
     *         "product_id": 7,
     *         "name": "Test Product 2",
     *         "price": "3.00",
     *         "quantity": 4
     *       }
     *     ],
     *     "total_price": 26,
     *     "status": "pending",
     *     "payment_reference_id": null,
     *     "paid_at": null,
     *     "created_at": "2025-05-24 12:32:20"
     *   }
     * }
     */

    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->placeOrder($request->validated()['items']);

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => new OrderResource($order->load('user'))
        ]);
    }


    /**
     * Get orders of the logged-in user
     *
     * Fetch all orders placed by the currently authenticated user.
     *
     * @group Orders
     * 
     * @authenticated
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 7,
     *       "items": [
     *         {
     *           "name": "Test Product",
     *           "price": "99.99",
     *           "quantity": 3,
     *           "product_id": 1
     *         }
     *       ],
     *       "total_price": "299.97",
     *       "status": "failed",
     *       "payment_reference_id": "txn_abc123",
     *       "paid_at": "2025-05-24 10:00:00",
     *       "created_at": "2025-05-24 08:34:33"
     *     }
     *   ]
     * }
     */

    public function userOrders()
    {
        $orders = $this->orderService->getUserOrders(Auth::id());
        return OrderResource::collection($orders);
    }

    /**
     * Get all orders (admin only)
     *
     * Retrieve all orders placed by all users. Only accessible to admin users.
     *
     * @group Orders
     * 
     * @authenticated
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 20,
     *       "user": {
     *         "id": 7,
     *         "name": "Jinu Varghese",
     *         "email": "jinuvarghese201820@gmail.com",
     *         "role": "user"
     *       },
     *       "items": [
     *         {
     *           "name": "Test Product",
     *           "price": "2.00",
     *           "quantity": 7,
     *           "product_id": 1
     *         },
     *         {
     *           "name": "Test Product 2",
     *           "price": "3.00",
     *           "quantity": 4,
     *           "product_id": 7
     *         }
     *       ],
     *       "total_price": "26.00",
     *       "status": "pending",
     *       "payment_reference_id": null,
     *       "paid_at": null,
     *       "created_at": "2025-05-24 13:46:20"
     *     },
     *     {
     *       "id": 7,
     *       "user": {
     *         "id": 6,
     *         "name": "Admin",
     *         "email": "admin@admin.com",
     *         "role": "admin"
     *       },
     *       "items": [
     *         {
     *           "name": "Test Product",
     *           "price": "99.99",
     *           "quantity": 3,
     *           "product_id": 1
     *         }
     *       ],
     *       "total_price": "299.97",
     *       "status": "failed",
     *       "payment_reference_id": "txn_abc123",
     *       "paid_at": "2025-05-24 10:00:00",
     *       "created_at": "2025-05-24 08:34:33"
     *     }
     *   ]
     * }
     */

    public function adminOrders()
    {
        $orders = $this->orderService->getAllOrders();
        return OrderResource::collection($orders);
    }
}
