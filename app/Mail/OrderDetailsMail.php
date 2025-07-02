<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderDetailsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $order;

    /**
     * Create a new message instance.
     *
     * @param  $order
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.emails.order_details_mail')
                    ->subject('Your Order Details')
                    ->with(['order' => $this->order]);
    }

    /**
     * Handle failures during queued sending.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        Log::error('OrderDetailsMail failed to send. Error: ' . $exception->getMessage(), [
            'order_id' => $this->order['id'] ?? null,
            'to' => $this->to,
        ]);
    }
}
