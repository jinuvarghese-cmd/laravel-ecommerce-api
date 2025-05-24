<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Confirmation')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your order has been placed successfully.')
            ->line('Order ID: ' . $this->order->id)
            ->line('Total: ₹' . $this->order->total_price)
            ->line('Thank you for shopping with us!');
    }
}
