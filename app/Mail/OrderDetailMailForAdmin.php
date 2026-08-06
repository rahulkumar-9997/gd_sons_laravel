<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderDetailMailForAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $order;
    public $customerName;

    public function __construct($order, $customerName)
    {
        $this->order = $order;
        $this->customerName = $customerName;
    }

    public function build()
    {
        $orderId = $this->order->order_id ?? 'N/A';
        $amount  = number_format($this->order->grand_total_amount ?? 0, 2);

        $mail = $this->view('frontend.emails.order_details_mail_for_admin')
            ->subject("New Order #{$orderId} — {$this->customerName} — Rs. {$amount}")
            ->with(['order' => $this->order]);

        // So admin can hit "reply" and it goes straight to the customer
        $customerEmail = $this->order->shippingAddress->email_id
            ?? optional($this->order->customer)->email
            ?? null;

        if (!empty($customerEmail)) {
            $mail->replyTo($customerEmail, $this->customerName);
        }

        return $mail;
    }

    public function failed(\Throwable $exception)
    {
        Log::error('OrderDetailMailForAdmin failed to send: ' . $exception->getMessage(), [
            'order_id' => $this->order->id ?? null,
        ]);
    }
}
