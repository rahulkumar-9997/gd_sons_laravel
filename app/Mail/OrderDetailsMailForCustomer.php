<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderDetailsMailForCustomer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $orderId = $this->order->order_id ?? 'N/A';

        return $this->view('frontend.emails.order_details_mail_for_customer')
            ->subject("Your GD Sons Order #{$orderId} is Confirmed!")
            ->replyTo('gdsons.vns@gmail.com', 'GD Sons Support')
            ->with(['order' => $this->order]);
    }

    public function failed(\Throwable $exception)
    {
        Log::error('OrderDetailsMailForCustomer failed to send: ' . $exception->getMessage(), [
            'order_id' => $this->order->id ?? null,
        ]);
    }
}
