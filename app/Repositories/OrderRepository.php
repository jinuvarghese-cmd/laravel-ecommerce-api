<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function create(array $data)
    {
        return Order::create($data);
    }

    public function find($id)
    {
        return Order::findOrFail($id);
    }

    public function userOrders($userId)
    {
        return Order::where('user_id', $userId)->latest()->get();
    }

    public function allOrders()
    {
        return Order::latest()->with('user')->get();
    }
}
