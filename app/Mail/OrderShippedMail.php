<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderShippedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $order;
    public function __construct($order)
    {
        $this->order = $order;
    }
    public function build()
    {
        return $this->view('backend.mail.orderShippedMail')
            ->subject('Your Order #' . $this->order->order_id . ' Has Shipped!')
            ->with(['order' => $this->order]);
    }

    public function failed(\Throwable $exception)
    {
        Log::error('OrderShippedMail failed to send: ' . $exception->getMessage(), [
            'order_id' => $this->order->id ?? null,
        ]);
    }
}
