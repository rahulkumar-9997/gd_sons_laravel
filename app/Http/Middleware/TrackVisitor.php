<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Torann\GeoIP\Facades\GeoIP;
use App\Models\VisitorTracking;
use App\Models\SocialMediaTracking;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        /** Social Media Management **/
        $this->SocialMediaTracking($request);
        
        if (!$request->isMethod('get') || $request->expectsJson() || $request->wantsJson()) {
            return $next($request); 
        }
        if ($this->isBot($request)) {
            return $next($request); 
        }

        if ($this->isBlockedIP($request->ip())) {
            Log::info("Blocked IP: " . $request->ip());
            return $next($request); 
        }
        $ipAddress = $request->ip();
        $browser = $request->header('User-Agent');
        $pageName = $request->fullUrl();
        $pageTitle = $this->getPageTitle($request);
        $currentDate = Carbon::now()->toDateString();
        if (preg_match('/\.(png|jpg|jpeg|gif|svg|css|js|woff|woff2|ttf|map|ico)$/i', $pageName) || $request->is('images/*', 'css/*', 'js/*')) {
            return $next($request);
        }

        /* Create a unique cache key*/
        $cacheKey = "visitor_tracking_{$ipAddress}_{$pageName}_{$currentDate}";
        $cacheDuration = now()->addDay();
        /* Cache for 1 day*/

        if (auth()->guard('customer')->check()) {
            $customerName = auth()->guard('customer')->user()->name;
        } else {
            $customerName = null;
        }
        if (!Cache::has($cacheKey)) {
            $location_array = GeoIP::getLocation($ipAddress);
            $location = [
                'city' => $location_array->city ?? 'Unknown',
                'country' => $location_array->country ?? 'Unknown',
                'state_name' => $location_array->state_name ?? 'Unknown',
                'postal_code' => $location_array->postal_code ?? 'Unknown',
                'currency' => $location_array->currency ?? 'Unknown',
            ];
            VisitorTracking::create([
                'ip_address' => $ipAddress,
                'browser' => $browser,
                'page_name' => $pageName,
                'location' => json_encode($location),
                'visited_at' => now(),
                'customer_name' => $customerName,
                'page_title' => $pageTitle,
            ]);

            Cache::put($cacheKey, true, $cacheDuration);
        }

        return $next($request);
    }

    /**
     * Check if the visitor is a bot.
     */
    private function isBot($request)
    {
        $agent = new Agent();
        if ($agent->isRobot()) {
            return true;
        }

        $userAgent = strtolower($request->header('User-Agent', ''));
        Log::info("Checking Bot: " . $userAgent);
        $bots = [
            'bot', 'crawl', 'spider', 'slurp', 'crawler', 'fetch', 'monitor', 'scraper',
            'google', 'bing', 'yahoo', 'duckduck', 'baidu', 'yandex', 'sogou', 'exabot',
            'facebookexternalhit', 'twitterbot', 'linkedinbot', 'pinterestbot', 'telegrambot',
            'whatsapp', 'discordbot', 'applebot', 'petalbot', 'mj12bot', 'semrushbot'
        ];

        foreach ($bots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Social Media Tracking
     */
    private function SocialMediaTracking($request)
    {
        if ($request->hasAny(['source', 'method', 'identity'])) {
            $source = $request->query('source', null);
            $method = $request->query('method', null);
            $identity = $request->query('identity', null);

            $ipAddress = $request->ip();
            $pageName = $request->fullUrl();
            $currentDate = Carbon::now()->toDateString();
            $cacheKey = "social_media_tracking_{$ipAddress}_{$currentDate}";
            $cacheDuration = now()->addDay(); // Cache for 1 day

            if (!Cache::has($cacheKey)) {
                $location_array = GeoIP::getLocation($ipAddress);
                $location = [
                    'city' => $location_array->city ?? 'Unknown',
                    'country' => $location_array->country ?? 'Unknown',
                    'state_name' => $location_array->state_name ?? 'Unknown',
                    'postal_code' => $location_array->postal_code ?? 'Unknown',
                    'currency' => $location_array->currency ?? 'Unknown',
                ];

                SocialMediaTracking::create([
                    'source' => $source,
                    'method' => $method,
                    'identity' => $identity,
                    'ip_address' => $ipAddress,
                    'browser' => $request->header('User-Agent'),
                    'page_name' => $pageName,
                    'location' => json_encode($location),
                    'visited_at' => now(),
                ]);

                // Store in cache
                Cache::put($cacheKey, true, $cacheDuration);
            }
        }
    }

    private function isBlockedIP($ip)
    {
        $blockedIPs = [
            '198.235.24.170',
            '198.235.24.136',
            '129.213.94.27'
        ];
    
        return in_array($ip, $blockedIPs);
    }
    private function getPageTitle($request)
    {
        // Method 1: Get from named routes
        if ($request->route() && $routeName = $request->route()->getName()) {
            return Str::title(str_replace('.', ' ', $routeName));
        }

        // Method 2: Get from view data (if you set title in controllers)
        if ($request->has('title')) {
            return $request->input('title');
        }

        // Method 3: Get from session (if you set it in controllers)
        if (session()->has('page_title')) {
            return session('page_title');
        }

        // Default title based on URL path
        $path = trim($request->path(), '/');
        if (empty($path)) {
            return 'Home Page';
        }

        return Str::title(str_replace(['-', '_', '/'], ' ', $path));
    }
}
