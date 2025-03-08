<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDetailMailForAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customerName;

    /**
     * Create a new message instance.
     *
     * @param  $order
     * @return void
     */
    public function __construct($order, $customerName)
    {
        $this->order = $order;
        $this->customerName = $customerName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.emails.order_details_mail')
        ->subject($this->order->customerName.' Place new order')
        ->with(['order' => $this->order]);
    }
}
