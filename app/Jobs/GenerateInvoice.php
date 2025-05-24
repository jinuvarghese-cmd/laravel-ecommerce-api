<?php

namespace App\Jobs;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GenerateInvoice implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        Storage::disk('public')->makeDirectory('invoices');

        $pdf = Pdf::loadView('order', ['order' => $this->order]);

        $filename = 'invoices/invoice_' . $this->order->id . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());
    }
}
