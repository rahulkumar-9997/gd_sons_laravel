<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulkEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('New Bulk Order Enquiry – ' . $this->data['name'])
            ->replyTo($this->data['email'], $this->data['name'])
            ->view('frontend.emails.bulk-enquiry');
    }
}