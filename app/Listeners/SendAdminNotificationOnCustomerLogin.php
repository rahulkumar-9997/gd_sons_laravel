<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminConfirmationLoginMail;
class SendAdminNotificationOnCustomerLogin
{
    
    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        // Check if the logged-in user is a customer (if using multiple guards)
        if (auth()->guard('customer')->check()) {
            // Send email notification to admin
            Mail::to('akshat.gd@gmail.com')->queue(new AdminConfirmationLoginMail($user));
        }
    }
}
