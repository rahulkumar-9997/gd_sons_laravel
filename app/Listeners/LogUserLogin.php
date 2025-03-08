<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Request;

class LogUserLogin
{
    public function handle(Login $event)
    {
        UserLogin::create([
            'user_id' => $event->user->id,
            'last_login_at' => now()->utc(),
            'ip_address' => Request::ip(),
        ]);
    }
}

