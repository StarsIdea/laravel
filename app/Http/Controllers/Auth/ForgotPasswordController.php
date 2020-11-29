<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\MailController;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function getEmail(){
        return view('auth.forgot-password');
    }

    public function postEmail(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        MailController::resetPassword($request->email,$token);

        // Mail::send('auth.verify-email', ['token' => $token], function($message) use ($request){
        //     $message->from('mvstars123@gmail.com');
        //     $message->to($request->email);
        //     $message->subject('Reset Password Notification');
        // });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    use SendsPasswordResetEmails;
}
