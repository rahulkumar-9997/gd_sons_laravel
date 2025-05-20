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
    private $botIpRanges = [
        '42.107.0.0/16',   // Added for Google Ads verification
        '66.249.64.0/19',  // Google
        '66.102.0.0/20',   // Google
        '66.220.144.0/20', // Facebook
        '69.63.176.0/20',  // Facebook
        '157.240.0.0/16',  // Facebook
        '173.252.64.0/18', // Facebook
        '108.174.0.0/16',  // Apple
        '17.0.0.0/8',      // Apple
        '146.75.0.0/16',   // Amazon
        '199.16.156.0/22', // Twitter
        '104.244.42.0/21', // Twitter
    ];

    private $adVerificationParams = [
        'gclid',        // Google Ads
        'gad_source',   // Google Ads
        'fbclid',       // Facebook
        'msclkid',      // Microsoft
        'twclid',       // Twitter
        'ttclid',       // TikTok
    ];

    private $botUserAgents = [
        'bot', 'crawl', 'spider', 'slurp', 'search',
        'fetcher', 'scraper', 'monitor', 'checker',
        'facebookexternalhit', 'twitterbot', 'linkedinbot',
        'pinterestbot', 'googlebot', 'bingbot', 'yandexbot',
        'duckduckbot', 'applebot', 'semrushbot', 'ahrefsbot',
        'mj12bot', 'petalbot', 'zoominfobot',
        'headless', 'phantomjs', 'selenium', 'curl',
        'wget', 'python-urllib', 'java', 'libwww-perl',
        'httpclient', 'go-http-client', 'apache-httpclient',
        'node-fetch', 'okhttp', 'axios'
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $this->SocialMediaTracking($request);
        if (!$request->isMethod('get') || $request->expectsJson() || $request->wantsJson()) {
            return $next($request);
        }
        
        // Skip static files
        if ($this->isStaticFile($request)) {
            return $next($request);
        }
        
        // Check for bots
        if ($this->isBot($request)) {
            $this->logBotDetection($request);
            return $next($request);
        }
        
        if ($this->isBlockedIP($request->ip())) {
            Log::info("Blocked IP: " . $request->ip());
            return $next($request);
        }

        // Track human visitors
        $this->trackVisitor($request);

        return $next($request);
    }

    /**
     * Track human visitors
     */
    private function trackVisitor(Request $request): void
    {
        $ipAddress = $request->getClientIp();
        $browser = $request->header('User-Agent');
        $pageName = $request->fullUrl();
        $pageTitle = $this->getPageTitle($request);
        $currentDate = Carbon::now()->toDateString();
        $sessionId = $request->session()->getId();
        
        $rawKey = "{$ipAddress}_{$sessionId}_{$pageName}_{$currentDate}";
        $cacheDuration = now()->addDay();
        $cacheKey = 'visitor_tracking_' . md5($rawKey);
        
        $customerName = auth()->guard('customer')->check()
            ? auth()->guard('customer')->user()->name
            : null;
        $lock = Cache::lock("lock_" . md5($rawKey), 10); // 10 seconds lock
        if ($lock->get()) {
            try {
                if (!Cache::has($cacheKey)) {
                    $location = $this->getLocationData($ipAddress);
                    $deviceInfo = $this->getDeviceInfo($request);

                    VisitorTracking::create([
                        'ip_address' => $ipAddress,
                        'browser' => $deviceInfo['browser'],
                        'page_name' => $pageName,
                        'location' => json_encode($location),
                        'visited_at' => now()->setTimezone('Asia/Kolkata'),
                        'customer_name' => $customerName,
                        'page_title' => $pageTitle,
                        'device_type' => $deviceInfo['device_type'],
                        'os' => $deviceInfo['os'],
                        'referrer' => $request->header('referer'),
                        'session_id' => $sessionId,
                        'device_category' => $deviceInfo['device_category'],
                    ]);
                     Cache::put($cacheKey, true, $cacheDuration);
                }

            } catch (\Exception $e) {
                Log::error("Visitor tracking failed: " . $e->getMessage());
            }
            finally {
                $lock->release();
            }
        }
    }

    /**
     * Enhanced bot detection
     */
    private function isBot(Request $request): bool
    {
        // 1. Basic checks
        $userAgent = $request->header('User-Agent');
        if (empty($userAgent) || $request->isMethod('head')) {
            return true;
        }

        // 2. Known bot IP ranges
        if ($this->isBotIp($request->ip())) {
            return true;
        }

        // 3. Ad verification traffic
        if ($this->isAdVerification($request)) {
            return true;
        }

        // 4. Rate limiting
        if ($this->isFlooding($request)) {
            return true;
        }

        // 5. User-Agent analysis
        if ($this->isBotUserAgent($userAgent)) {
            return true;
        }

        // 6. Fragment requests
        if ($request->has('_escaped_fragment_')) {
            return true;
        }

        // 7. No session interaction
        if (!$this->hasValidSession($request)) {
            return true;
        }

        return false;
    }

    /**
     * Check for static files
     */
    private function isStaticFile(Request $request): bool
    {
        $path = $request->path();
        return preg_match('/\.(png|jpg|jpeg|gif|svg|css|js|woff|woff2|ttf|map|ico|webp)$/i', $path) ||
               $request->is('images/*', 'css/*', 'js/*', 'fonts/*', 'assets/*');
    }

    /**
     * Check if IP belongs to known bot ranges
     */
    private function isBotIp(string $ip): bool
    {
        foreach ($this->botIpRanges as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if IP is in CIDR range
     */
    private function ipInRange(string $ip, string $range): bool
    {
        list($subnet, $bits) = explode('/', $range);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;
        return ($ip & $mask) === $subnet;
    }

    /**
     * Detect ad verification traffic
     */
    private function isAdVerification(Request $request): bool
    {
        $url = $request->fullUrl();
        foreach ($this->adVerificationParams as $param) {
            if (str_contains($url, $param . '=')) {
                return true;
            }
        }
        return false;
    }

    /**
     * Flood detection
     */
    private function isFlooding(Request $request): bool
    {
        $ip = $request->ip();
        $cacheKey = "request_rate_{$ip}";
        $maxRequests = 15; // Max 15 requests per minute
        
        $count = Cache::get($cacheKey, 0);
        if ($count >= $maxRequests) {
            return true;
        }
        
        Cache::put($cacheKey, $count + 1, now()->addMinutes(1));
        return false;
    }

    /**
     * Bot user agent detection
     */
    private function isBotUserAgent(string $userAgent): bool
    {
        $userAgent = strtolower($userAgent);
        foreach ($this->botUserAgents as $pattern) {
            if (str_contains($userAgent, $pattern)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check for valid session interaction
     */
    private function hasValidSession(Request $request): bool
    {
        if (!$request->hasSession()) {
            return false;
        }

        $session = $request->session();
        $pageViews = $session->get('page_views', 0);
        $session->put('page_views', $pageViews + 1);

        // New sessions with multiple requests are suspicious
        if ($pageViews < 3 && $this->isFlooding($request)) {
            return false;
        }

        return true;
    }

    /**
     * Log bot detection details
     */
    private function logBotDetection(Request $request): void
    {
        $reason = $this->getDetectionReason($request);
        Log::info('Bot detected', [
            'ip' => $request->ip(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->header('User-Agent'),
            'referrer' => $request->header('referer'),
            'reason' => $reason,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Get detection reason for logging
     */
    private function getDetectionReason(Request $request): string
    {
        if (empty($request->header('User-Agent'))) {
            return 'Empty User-Agent';
        }

        if ($this->isBotIp($request->ip())) {
            return 'Known bot IP range';
        }

        if ($this->isAdVerification($request)) {
            return 'Ad verification traffic';
        }

        if ($this->isFlooding($request)) {
            return 'Request flooding';
        }

        if ($this->isBotUserAgent($request->header('User-Agent'))) {
            return 'Bot User-Agent pattern';
        }

        if ($request->isMethod('head')) {
            return 'HEAD request';
        }

        if ($request->has('_escaped_fragment_')) {
            return 'Escaped fragment';
        }

        if (!$this->hasValidSession($request)) {
            return 'Invalid session behavior';
        }

        return 'Unknown';
    }

    /**
     * Social Media Tracking
     */
    private function SocialMediaTracking(Request $request): void
    {
        if ($request->hasAny(['source', 'method', 'identity'])) {
            $source = $request->query('source', null);
            $method = $request->query('method', null);
            $identity = $request->query('identity', null);

            $ipAddress = $request->ip();
            $currentDate = Carbon::now()->toDateString();
            $cacheKey = "social_media_tracking_{$ipAddress}_{$currentDate}";
            $cacheDuration = now()->addDay();

            if (!Cache::has($cacheKey)) {
                try {
                    $location = $this->getLocationData($ipAddress);

                    SocialMediaTracking::create([
                        'source' => $source,
                        'method' => $method,
                        'identity' => $identity,
                        'ip_address' => $ipAddress,
                        'browser' => $request->header('User-Agent'),
                        'page_name' => $request->fullUrl(),
                        'location' => json_encode($location),
                        'visited_at' => now(),
                    ]);

                    Cache::put($cacheKey, true, $cacheDuration);
                } catch (\Exception $e) {
                    Log::error("Social media tracking failed: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Get location data from IP
     */
    private function getLocationData(string $ip): array
    {
        try {
            $location = GeoIP::getLocation($ip);
            return [
                'city' => $location->city ?? 'Unknown',
                'country' => $location->country ?? 'Unknown',
                'state_name' => $location->state_name ?? 'Unknown',
                'postal_code' => $location->postal_code ?? 'Unknown',
                'currency' => $location->currency ?? 'Unknown',
                'timezone' => $location->timezone ?? 'Unknown',
                'isp' => $location->isp ?? 'Unknown',
                'lat' => $location->lat ?? null,
                'lon' => $location->lon ?? null,
            ];
        } catch (\Exception $e) {
            Log::warning("GeoIP lookup failed for IP {$ip}: " . $e->getMessage());
            return [
                'city' => 'Unknown',
                'country' => 'Unknown',
                'state_name' => 'Unknown',
                'postal_code' => 'Unknown',
                'currency' => 'Unknown',
                'timezone' => 'Unknown',
                'isp' => 'Unknown',
                'lat' => null,
                'lon' => null,
            ];
        }
    }

    /**
     * Get device information
     */
    private function getDeviceInfo(Request $request): array
    {
        $agent = new Agent();
        $userAgent = $request->header('User-Agent');
        if ($agent->isMobile()) {
            $deviceCategory = 'Mobile';
        } elseif ($agent->isTablet()) {
            $deviceCategory = 'Tablet';
        } elseif ($agent->isDesktop()) {
            $deviceCategory = 'Desktop';
        } else {
            $deviceCategory = 'Unknown';
        }
        return [
            'device_type' => $agent->device() ?: 'Unknown',
            'os' => $agent->platform() ?: 'Unknown',
            'device_category' => $deviceCategory,
            'browser' => $agent->browser() ?: 'Unknown',
            'browser_version' => $agent->version($agent->browser()) ?: 'Unknown',
        ];
    }

    /**
     * Blocked IPs
     */
    private function isBlockedIP(string $ip): bool
    {
        $blockedIPs = [
            '198.235.24.170',
            '198.235.24.136',
            '129.213.94.27'
        ];

        return in_array($ip, $blockedIPs);
    }

    /**
     * Get page title
     */
    private function getPageTitle(Request $request): string
    {
        if ($request->route() && $routeName = $request->route()->getName()) {
            return Str::title(str_replace('.', ' ', $routeName));
        }
        if ($request->has('title')) {
            return $request->input('title');
        }
        if (session()->has('page_title')) {
            return session('page_title');
        }
        try {
            if ($request->isMethod('get') && !$request->expectsJson()) {
                $content = file_get_contents($request->fullUrl());
                if (preg_match('/<title>(.*?)<\/title>/', $content, $matches)) {
                    return html_entity_decode($matches[1]);
                }
            }
        } catch (\Exception $e) {
            // Silent fail
        }
        $path = trim($request->path(), '/');
        if (empty($path)) {
            return 'Home Page';
        }

        return Str::title(str_replace(['-', '_', '/'], ' ', $path));
    }
}