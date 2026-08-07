<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderDeliveredMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $order;
    public $coupon;
    public function __construct($order, $coupon = null)
    {
        $this->order = $order;
        $this->coupon = $coupon;
    }
    public function build()
    {
        return $this->view('backend.mail.orderDeliveredMail')
            ->subject('Your Order #' . $this->order->order_id . ' Has Been Delivered!')
            ->with(['order' => $this->order, 'coupon' => $this->coupon]);
    }

    public function failed(\Throwable $exception)
    {
        Log::error('OrderDeliveredMail failed to send: ' . $exception->getMessage(), [
            'order_id' => $this->order->id ?? null,
        ]);
    }
}
