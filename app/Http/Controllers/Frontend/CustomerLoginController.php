<?php
namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\CustomerOtpMail;
use App\Models\Notification;


class CustomerLoginController extends Controller
{
    public function showCustomerLoginForm(){
        return view('frontend.pages.customer-auth.customer-login');
    }

    public function requestOtp(Request $request)
    {
        $request->validate([
            'emailOrWhatsappNo' => 'required',
        ], [
            'emailOrWhatsappNo.required' => 'This field is required.',
        ]);
        
        $input = $request->emailOrWhatsappNo;
        $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL);
        $isMobile = preg_match('/^[6-9]\d{9}$/', $input);
        $otp = (string) rand(100000, 999999);
        //$otpMobile = string()
        $sessionData = [
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
        ];
        if ($isEmail) {
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['success' => false, 'message' => 'Please provide a valid email address.']);
            }
        } elseif ($isMobile) {
            if (strlen($input) != 10) {
                return response()->json(['success' => false, 'message' => 'Please provide a valid 10-digit mobile number.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Please provide a valid email or mobile number.']);
        }
        
        if ($isEmail) {
            $customer = Customer::where('email', $input)->first();
        } else {
            $customer = Customer::where('phone_number', $input)->first();
        }
        $message = $customer ? 'OTP sent for login.' : 'OTP sent for registration.';
        
        if ($isEmail) {
            $sessionData['email'] = $input;
            Mail::to($input)->queue(new CustomerOtpMail($otp));
        } elseif ($isMobile) {
            $sessionData['phone_number'] = $input;
            $mobile_number = '91' . $input;
            Log::info('mobile Number:', ['no' => $mobile_number]);
            Log::info('oTP:', ['no' => $otp]);
            $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY";
            
            $response = Http::post('https://backend.aisensy.com/campaign/t1/api/v2', [
                'apiKey' => $apiKey,
                'campaignName' => 'gdsons_login_otp',
                'destination' =>$mobile_number,
                'userName' => $mobile_number,
                'templateParams' => [$otp],
                'source' => 'new-landing-page form',
                'media' => new \stdClass(),
                'buttons' => [
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => 0,
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $otp
                            ]
                        ]
                    ]
                ],
                'carouselCards' => [],
                'location' => new \stdClass(),
                'attributes' => new \stdClass(),
                'paramsFallbackValue' => [
                    'FirstName' => 'user'
                ]
            ]);
    
            if ($response->failed()) {
                $errorResponse = $response->json();
                Log::error('AiSensy OTP API Error:', $errorResponse);
            
                return response()->json([
                    'success' => false,
                    'message' => $errorResponse,
                    'error' => $errorResponse,
                ]);
            }
        }
        Session::put('otp', $sessionData);
        return response()->json([
            'success' => true,
            'message' => $message,
            'contact' => $input,
            //'otp' => $otp,
        ]);
    }


    public function verifyOtp(Request $request){
        $request->validate([
            'otp' => 'required|digits:6',
        ]);
    
        $sessionOtp = Session::get('otp');
        Log::info('Session OTP:', ['otp' => $sessionOtp['otp']]);
        Log::info('Received OTP:', ['otp' => $request->otp]);
        if (!$sessionOtp || empty($sessionOtp['expires_at']) || now()->greaterThan($sessionOtp['expires_at'])) {
            return response()->json(['error' => 'OTP session expired, please request a new OTP.'], 422);
        }
    
        if ((string) $request->otp != $sessionOtp['otp']) {
            return response()->json(['error' => 'Invalid OTP.'], 422);
        }
        $contactField = isset($sessionOtp['email']) ? 'email' : 'phone_number';
        $contactValue = $sessionOtp[$contactField] ?? null;
    
        if (!$contactValue) {
            return response()->json(['error' => 'Invalid session data.'], 422);
        }
        $customer = Customer::where($contactField, $contactValue)->first();
        
    
        if ($customer) {
            Auth::guard('customer')->login($customer);
            $this->sendNotification($customer, "Currently {$customer->name} has logged in.");
            $redirectUrl = $request->input('redirect', url('/'));
            Session::forget('otp');
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully.',
                'displayform' => 0,
                'redirect_url' => $redirectUrl,
                'contact_field' => $contactField,
                'contact_value' => $contactValue,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully. Proceed with registration.',
            'displayform' => 1,
            'contact_field' => $contactField,
            'contact_value' => $contactValue,
        ]);
        
    }

    public function resendOtp(){
        $sessionOtp = Session::get('otp');
        if (!$sessionOtp || (!isset($sessionOtp['email']) && !isset($sessionOtp['phone_number']))) {
            return response()->json(['error' => 'Session expired or invalid data. Please request OTP again.'], 422);
        }
        if (Session::has('otp_resend_attempts')) {
            if (Session::get('otp_resend_attempts') >= 3) {
                return response()->json(['error' => 'Too many OTP resend attempts. Please try again later.'], 429);
            }
        }

        $otp = (string) rand(100000, 999999);
        $sessionOtp['otp'] = $otp;
        $sessionOtp['expires_at'] = now()->addMinutes(10);
        Session::put('otp', $sessionOtp);
        Session::put('otp_resend_attempts', Session::get('otp_resend_attempts', 0) + 1);

        $message = '';
        if (!empty($sessionOtp['email'])) {
            Mail::to($sessionOtp['email'])->queue(new CustomerOtpMail($otp));
            $message = 'OTP resent successfully to your email.';
        } elseif (!empty($sessionOtp['phone_number'])) {
            $this->sendSmsOtp($sessionOtp['phone_number'], $otp);
            $message = 'OTP resent successfully to your mobile number.';
        }

        Log::info("OTP resent to: " . ($sessionOtp['email'] ?? $sessionOtp['phone_number']));

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function customerUpdateDetails(Request $request){
        $request->validate([
            'phone' => 'nullable|regex:/^[0-9]{10}$/',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);
        
        $redirectUrl = $request->input('redirect', url('/'));
        Log::info('Redirect URL:', ['redirect_url' => $redirectUrl]);
        $sessionOtp = Session::get('otp');
        Log::info('Session OTP:', ['otp' => $sessionOtp]);
        $email = $request->email;
        $phone = $request->phone;
        $customer = Customer::where('email', $email)->orWhere('phone_number', $phone)->first();
        Session::forget('otp');
        if ($customer) {
            Auth::guard('customer')->login($customer);
            // **Notification insert**
            $this->sendNotification($customer, "Currently {$customer->name} has logged in.");
            return response()->json([
                'success' => true,
                'message' => 'You have successfully signed in. Welcome back!',
                'user' => $customer,
                'redirect_url' => $redirectUrl,
            ]);
        } else {
            $randomPassword = Str::random(8);
            $hashedPassword = Hash::make($randomPassword);
            $newUser = Customer::create([
                'name' => $request->name,
                'phone_number' => $request->phone,
                'email' => $email,
                'password' => $hashedPassword,
            ]);
            Auth::guard('customer')->login($newUser);
            // **Notification insert**
            $this->sendNotification($newUser, "Currently {$newUser->name} has logged in.");
            // Optionally, send a welcome email with the generated password
            // Mail::to($newUser->email)->send(new WelcomeEmail($randomPassword));
            return response()->json([
                'success' => true,
                'message' => 'Account created successfully. Welcome!',
                'user' => $newUser,
                'redirect_url' => $redirectUrl,
            ]);
        }
    }
    
    public function redirectToGoogle(Request $request){
        $redirectUrl = $request->query('redirect', route('home'));
        session(['redirect_url' => $redirectUrl]);
        return Socialite::driver('google')->redirect();
    }
    // https://www.codexworld.com/login-with-google-api-using-php/
    public function handleGoogleCallback(Request $request){
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = Customer::where('email', $googleUser->getEmail())->first();
            // dd(session('redirect_url', route('home')));
            // dd([
            //     'client_id' => config('services.google.client_id'),
            //     'client_secret' => config('services.google.client_secret'),
            //     'redirect_uri' => config('services.google.redirect')
            // ]);
            if ($user) {
                $this->sendNotification($user, "Currently {$user->name} has logged in.");
                Auth::guard('customer')->login($user);
                $redirectUrl = session('redirect_url', route('home'));
                return redirect()->to($redirectUrl);
            } else {
                $randomPassword = Str::random(16);
                $hashedPassword = Hash::make($randomPassword);
        
                $user = Customer::create([
                    'email' => $googleUser->getEmail(),
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => $hashedPassword, 
                ]);
                $this->sendNotification($user, "Currently {$user->name} has logged in.");
                Auth::guard('customer')->login($user);
               $redirectUrl = session('redirect_url', route('home'));
               return redirect()->to($redirectUrl);
            }
            return redirect()->to($redirectUrl);
        } catch (\Exception $e) {
            return back()->with('error', 'Google login failed. Please try again.');
        }
    }

    public function CustomerLogout(Request $request){
        try {
            Auth::guard('customer')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('success', 'You have been logged out successfully!');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Something went wrong while logging out. Please try again.');
        }
    }

    private function sendSmsOtp($phoneNumber, $otp){
        $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY";
            
        $response = Http::post('https://backend.aisensy.com/campaign/t1/api/v2', [
            'apiKey' => $apiKey,
            'campaignName' => 'gdsons_login_otp',
            'destination' => '91' . $phoneNumber,
            'userName' => $phoneNumber,
            'templateParams' => [$otp],
            'source' => 'new-landing-page form',
            'media' => new \stdClass(),
            'buttons' => [
                [
                    'type' => 'button',
                    'sub_type' => 'url',
                    'index' => 0,
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => $otp
                        ]
                    ]
                ]
            ],
            'carouselCards' => [],
            'location' => new \stdClass(),
            'attributes' => new \stdClass(),
            'paramsFallbackValue' => [
                'FirstName' => 'user'
            ]
        ]);

        if ($response->failed()) {
            $errorResponse = $response->json();
            Log::error('AiSensy OTP API Error:', $errorResponse);
        
            return response()->json([
                'success' => false,
                'message' => $errorResponse,
                'error' => $errorResponse,
            ]);
        }
    }

    private function sendNotification($user, $message)
    {
        Notification::create([
            'customer_id' => $user->id,
            'title' => 'New Login',
            'message' => $message,
        ]);
    }

    public function getNotifications(){
        // $customer = auth('customer')->user();
        // $customerId = $customer->id;
        // $notifications = Notification::where('customer_id', '!=', $customerId)
        // ->where('is_read', 0)
        // ->latest()
        // ->take(1)
        // ->get();
        // return response()->json($notifications);
        $customer = auth('customer')->user();
        $customerId = $customer->id;
        $notifications = Notification::where('customer_id', '!=', $customerId)
            ->where('is_read', 0)
            ->orderBy('id', 'asc')
            ->first();

        if ($notifications) {
            $notifications->update(['is_read' => 1]);
        }

        return response()->json($notifications);
    }

    public function markAsRead($id){
        $notification = Notification::findOrFail($id);
        if ($notification) {
            $notification->update(['is_read' => 1]);
            return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
        }
        return response()->json(['error' => 'Notification not found'], 404);        
    }


}
