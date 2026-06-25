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
    public function getServiceability_old(string $from_pin, string $to_pin, float $weight_kg = 0.5, int $cod = 0)
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

    public function getServiceability(array $params): array
    {
        $token = $this->getToken();
        if (!$token) {
            return [
                'success' => false,
                'message' => 'Shiprocket token unavailable.',
            ];
        }
        $payload = array_filter([
            'pickup_postcode'   => $params['pickup_postcode'] ?? null,
            'delivery_postcode' => $params['delivery_postcode'] ?? null,
            'order_id'          => $params['order_id'] ?? null,
            'cod'               => $params['cod'] ?? 0,
            'weight'            => $params['weight'] ?? null,
            'length'            => $params['length'] ?? null,
            'breadth'           => $params['breadth'] ?? null,
            'height'            => $params['height'] ?? null,
            'declared_value'    => $params['declared_value'] ?? null,
            'mode'              => $params['mode'] ?? null,
            'is_return'         => $params['is_return'] ?? null,
            'couriers_type'     => $params['couriers_type'] ?? null,
            'only_local'        => $params['only_local'] ?? null,
            'qc_check'          => $params['qc_check'] ?? null,
        ], fn ($value) => $value !== null && $value !== '');
        Log::info('Shiprocket Serviceability Request', [
            'payload' => $payload
        ]);
        $response = Http::withToken($token)
            ->timeout(30)
            ->get("{$this->base}/courier/serviceability/", $payload);
        
        Log::info(
            "Shiprocket Serviceability Response\n" .
            json_encode(
                $response->json(),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            )
        );
        if (!$response->successful()) {
            return [
                'success' => false,
                'message' => 'Shiprocket API Error',
                'response' => $response->json(),
            ];
        }
        $data = $response->json();
        return [
            'success' => (
                ($data['status'] ?? null) == 200 &&
                !empty($data['data']['available_courier_companies'])
            ),
            'raw' => $data,
            'message' => $data['message'] ?? null,
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
