<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProductEnquiryMailForAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $enquiry;
    public $product;
    public $productPrice;

    public function __construct($enquiry, $product, $productPrice)
    {
        $this->enquiry     = $enquiry;
        $this->product     = $product;
        $this->productPrice = $productPrice;
    }

    public function build()
    {
        $mail = $this->view('frontend.emails.product_enquiry_mail_for_admin')
            ->subject('New Enquiry #' . $this->enquiry->id . ' — ' . ucwords(strtolower($this->product->title)))
            ->with([
                'enquiry'      => $this->enquiry,
                'product'      => $this->product,
                'productPrice' => $this->productPrice,
            ]);

        if (!empty($this->enquiry->email)) {
            $mail->replyTo($this->enquiry->email, $this->enquiry->name ?: 'Customer');
        }

        return $mail;
    }

    public function failed(\Throwable $exception)
    {
        Log::error('ProductEnquiryMailForAdmin failed to send: ' . $exception->getMessage(), [
            'enquiry_id' => $this->enquiry->id ?? null,
        ]);
    }
}
