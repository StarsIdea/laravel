<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */

    public function getPassword($token){

        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_resets')
                                ->where(['token' => $request->input('token')])
                                ->first();


        if(!$updatePassword)
            return back()->withInput()->with('error', 'Invalid token!');

        $email = $updatePassword->email;

        User::where('email', $email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $email])->delete();

        return redirect('/login')->with('message', 'Your password has been');
    }

    protected $redirectTo = RouteServiceProvider::HOME;
}
