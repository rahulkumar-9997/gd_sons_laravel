<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated using the "web" guard
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        // Redirect to the login page or throw a 403 error
        return redirect()->route('login')->with('error', 'Unauthorized access');
    }
}
