<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{

    public function showForgotForm()
    {
        return view('auth.passwords.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'The email address is not registered.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Reset link sent to your ' . $request->email)
            : back()->withErrors(['email' => __($status)]);
    }

    // Show the reset password form
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email, // Pass the email to the view
        ]);
    }


    // Handle password reset
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $user = User::where('email', $request->email)->first();
            if ($user && $user->hasRole('clinic')) {
                return redirect()->back()->with('status', 'Password reset successfully. Now you can login with new password in mobile app');
            }
            return redirect()->route('login')->with('status', 'Password reset successfully. Now you can login with new password');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
