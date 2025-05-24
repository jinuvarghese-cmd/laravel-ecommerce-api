<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class CancelOldOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-old-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $cutoff = Carbon::now()->subHour();

        $orders = Order::where('status', 'pending')
                       ->where('created_at', '<', $cutoff)
                       ->get();

        foreach ($orders as $order) {
            $order->status = 'cancelled';
            $order->save();

            foreach ($order->items as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                } 
            }

            $this->info("Cancelled order ID: {$order->id}");
        }

        $this->info("Old pending orders cancelled.");
        return Command::SUCCESS;
    }
}
