<?php
use App\Models\SpecialOffer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

if (!function_exists('numberToWords')) {
    function numberToWords($number) {
        $words = [
            0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
            18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety'
        ];

        if ($number < 21) {
            return $words[$number];
        } elseif ($number < 100) {
            return $words[$number - ($number % 10)] . ($number % 10 ? ' ' . $words[$number % 10] : '');
        } elseif ($number < 1000) {
            return $words[intval($number / 100)] . ' Hundred' . ($number % 100 ? ' ' . numberToWords($number % 100) : '');
        } elseif ($number < 1000000) {
            return numberToWords(intval($number / 1000)) . ' Thousand' . ($number % 1000 ? ' ' . numberToWords($number % 1000) : '');
        }

        return 'Number out of range';
    }
}

if (!function_exists('getCustomerSpecialOffers')) {
    function getCustomerSpecialOffers()
    {
        $customer = Auth::guard('customer')->user();
        $specialOffers = [];
        if ($customer) {
            $offers = SpecialOffer::where('customer_id', $customer->id)
            ->get();

            foreach ($offers as $offer) {
                $specialOffers[$offer->product_id] = $offer->special_offer_rate;
            }
        }
        return $specialOffers;
    }
}

function removeDuplicateWords($sentence) {
    $words = explode(' ', $sentence);
    $seen = [];
    $result = [];
    
    foreach ($words as $word) {
        $lowerWord = strtolower($word);
        if (!in_array($lowerWord, $seen)) {
            $seen[] = $lowerWord;
            $result[] = $word; 
        }
    }
    
    return implode(' ', $result);
}

function sendSmsOtp($phoneNumber, $otp)
{
    $otpMessage = "$otp is your OTP to log in into website https://www.gdsons.co.in. Please do not share this with anyone.";

    $url = "http://fastgosms.in/http-tokenkeyapi.php?" . http_build_query([
        'authentic-key' => '3135676972646861723130301749132263',
        'senderid' => 'GDNSON',
        'route' => '16',
        'number' => $phoneNumber,
        'message' => $otpMessage,
        'templateid' => '1707174913259233425'
    ]);

    $response = Http::get($url);

    if ($response->failed()) {
        Log::error('FastGoSMS OTP API Error:', ['response' => $response->body()]);
        return false;
    }

    return true;
}



