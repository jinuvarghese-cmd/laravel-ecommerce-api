<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    protected $orderRepo;
    protected $productRepo;

    public function __construct(OrderRepository $orderRepo, ProductRepository $productRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * Place an order with validation and stock decrement
     */
    public function placeOrder(array $items)
    {
        DB::beginTransaction();

        try {
            $orderItems = [];
            $total = 0;

            foreach ($items as $item) {
                $product = $this->productRepo->find($item['product_id']);
                $quantity = $item['quantity'];

                if ($product->stock < $quantity) {
                    throw new Exception("Not enough stock for {$product->name}");
                }

                $product->decrement('stock', $quantity);
                $total += $product->price * $quantity;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                ];
            }

            $order = $this->orderRepo->create([
                'user_id' => Auth::id(),
                'items' => $orderItems,
                'total_price' => $total,
                'status' => 'pending',
            ]);

            DB::commit();

            event(new OrderPlaced($order));

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getUserOrders($userId)
    {
        return $this->orderRepo->userOrders($userId);
    }

    public function getAllOrders()
    {
        return $this->orderRepo->allOrders();
    }
}
