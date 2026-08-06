<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProductEnquiryMailForCustomer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $enquiry;
    public $product;
    public $productImage;
    public $productPrice;

    public function __construct($enquiry, $product, $productImage, $productPrice)
    {
        $this->enquiry      = $enquiry;
        $this->product      = $product;
        $this->productImage = $productImage;
        $this->productPrice = $productPrice;
    }

    public function build()
    {
        return $this->view('frontend.emails.product_enquiry_mail_for_customer')
            ->subject('We\'ve Received Your Enquiry — ' . ucwords(strtolower($this->product->title)))
            ->with([
                'enquiry'      => $this->enquiry,
                'product'      => $this->product,
                'productImage' => $this->productImage,
                'productPrice' => $this->productPrice,
            ]);
    }

    public function failed(\Throwable $exception)
    {
        Log::error('ProductEnquiryMailForCustomer failed to send: ' . $exception->getMessage(), [
            'enquiry_id' => $this->enquiry->id ?? null,
        ]);
    }
}
