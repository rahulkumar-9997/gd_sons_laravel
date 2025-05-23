<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
class LogUserLogin
{
    public function handle(Login $event)
    {
        if (Auth::getDefaultDriver() !== 'customer' && $event->user instanceof \App\Models\User) {
            UserLogin::create([
                'user_id' => $event->user->id,
                'last_login_at' => now()->utc(),
                'ip_address' => Request::ip(),
            ]);
        }
    }
}

