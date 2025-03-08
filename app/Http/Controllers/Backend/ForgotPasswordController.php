<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use App\Mail\AdminResetPasswordMail; 
use Illuminate\Support\Facades\Log;


class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm(){
        return view('backend.auth.forget-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);
        try {
            $data = [
                'token' => $token,
            ];
            Mail::to($request->email)->queue(new AdminResetPasswordMail($data));
            Log::info('Email sent successfully to '.$request->email.'');
        } 
        catch(Exception $e){
            Log::error('Error sending email: ' . $e->getMessage());
        }
        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm(Request $request, $token) {
        $resetRequest = DB::table('password_resets')
        ->where('token', $token)
        ->first();
        if (!$resetRequest) {
            return redirect('admin/login')->with('error', 'Invalid password reset request.');
        } 
        return view('backend.auth.forget-password-link', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
  
        $updatePassword = DB::table('password_resets')
        ->where([
        'email' => $request->email, 
        'token' => $request->token
        ])
        ->first();
                            
        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }
  
        $user = User::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);
 
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
        return redirect('admin/login')->with('success', 'Your password has been changed!');
      }
}
