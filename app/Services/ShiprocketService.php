<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ShiprocketToken;

class ShiprocketService
{
    protected $base;

    public function __construct()
    {
        $this->base = config('services.shiprocket.shiprocket_base_url', 'https://apiv2.shiprocket.in/v1/external');
    }

    /**
     * Authenticate with Shiprocket and get token
     */
    public function authenticate()
    {
        $email = config('services.shiprocket.shiprocket_email');
        $password = config('services.shiprocket.shiprocket_password');

        Log::info('App services email password', [
            'email' => $email,
            'password' => $password,
        ]);

        $resp = Http::post("{$this->base}/auth/login", [
            'email' => $email,
            'password' => $password,
        ]);
        $data = $resp->json();
        Log::info('Shiprocket Auth Response', [
            'response' => print_r($data, true),
        ]);
        if ($resp->successful() && isset($data['token'])) {
            return $data['token'];
        }
        return null;
    }

    /**
     * Fetch token from DB, refresh if expired
     */
    public function getToken()
    {
        $record = ShiprocketToken::first();
        /* If no record or no token → Generate new token */
        if (!$record || !$record->token) {
            return $this->refreshToken();
        }

        $createdAt = strtotime($record->token_created_at);
        $now = time();
        $diff = $now - $createdAt;

        /* Shiprocket Token Expiry = 10 days = 864000 seconds*/
        if ($diff > 864000) {
            Log::info("Shiprocket token expired. Generating new one...");
            return $this->refreshToken();
        }

        return $record->token;
    }

    /**
     * Refresh Shiprocket token and store in DB
     */
    public function refreshToken()
    {
        $token = $this->authenticate();
        if ($token) {
            ShiprocketToken::updateOrCreate(
                ['id' => 1],
                [
                    'token' => $token,
                    'token_created_at' => now()
                ]
            );
        }

        return $token;
    }

    /**
     * Get serviceability and rates
     */
    public function getServiceability(string $from_pin, string $to_pin, float $weight_kg = 0.5, int $cod = 0)
    {
        $token = $this->getToken();
        if (!$token) {
            return [
                'success' => false,
                'message' => 'Token not available'
            ];
        }

        $resp = Http::withToken($token)
            ->get("{$this->base}/courier/serviceability/", [
                'pickup_postcode' => $from_pin,
                'delivery_postcode' => $to_pin,
                'weight' => (string) $weight_kg,
                'cod' => $cod,
            ]);

        if (!$resp->successful()) {
            return [
                'success' => false,
                'message' => 'API Error',
                'response' => $resp->json()
            ];
        }
        $data = $resp->json();
        /*Log::info('Shiprocket Serviceability Response', [
            'response' => print_r($data, true),
        ]);*/
        if
        (
            isset($data['status']) && $data['status'] == 200 &&
            isset($data['data']['available_courier_companies']) &&
            !empty($data['data']['available_courier_companies'])
        )
        {
            return [
                'success' => true,
                'raw' => $data,
            ];
        }
        return [
            'success' => false,
            'raw' => $data,
        ];
    }

    public function getShiprocketLocalityDetails($pinCode)
    {
        $token = $this->getToken();
        if (!$token) {
            return [
                'success' => false,
                'message' => 'Token not available'
            ];
        }
        $url = "https://apiv2.shiprocket.in/v1/external/open/postcode/details";
        $resp = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->get($url, [
                'postcode' => $pinCode
            ]);
        if (!$resp->successful()) {
            return [
                'success' => false,
                'message' => 'API Error',
                'response' => $resp->json()
            ];
        }
        return [
            'success' => true,
            'data' => $resp->json()['postcode_details'] ?? []
        ];
    }


}
