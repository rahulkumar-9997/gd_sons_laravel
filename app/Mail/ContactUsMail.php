<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Http\Request;

class ContactUsMail extends Mailable
{
    public $data;

    public function __construct(Request $request){
        $this->data = $request;
    }

    public function build(){
        return $this->view('frontend.pages.email.contactus')
        ->subject('Contact Us Message')
        ->with([
            'name' => $this->data->name,
            'email' => $this->data->email,
            'phone' => $this->data->phone,
            'userMessage' => $this->data->message,
        ]);
    }
}
