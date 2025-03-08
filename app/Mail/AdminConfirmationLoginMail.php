<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class AdminConfirmationLoginMail extends Mailable
{
    public $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function build()
    {
        return $this->subject('Customer Login Notification')
                    ->view('frontend.emails.admin_login_notification')
                    ->with(['customer' => $this->customer]);
    }
}
