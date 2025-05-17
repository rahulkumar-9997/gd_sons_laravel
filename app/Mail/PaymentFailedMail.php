<?php

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Orders $order,
        public string $reason,
        public ?string $customerName = null,
        public bool $isAdmin = false
    ) {
        // Constructor properties are promoted (PHP 8.0+ feature)
    }

    public function build()
    {
        $subject = $this->isAdmin
            ? '[ADMIN ALERT] Payment Failed for Order #' . $this->order->order_id
            : 'Payment Failed for Order #' . $this->order->order_id;

        return $this->subject($subject)
            ->view('emails.payment_failed')
            ->with([
                'order' => $this->order,
                'reason' => $this->reason,
                'customerName' => $this->customerName,
                'isAdmin' => $this->isAdmin,
                'retryUrl' => route('checkout')
            ]);
    }
}