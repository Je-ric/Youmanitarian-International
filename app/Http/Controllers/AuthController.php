<?php

namespace App\Http\Controllers;

// use Password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // auth/login.blade.php (main)
    public function showLogin()
    {
        return view('auth.login');
    }

    // auth/login.blade.php (main)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    // auth/register.blade.php (main)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)              // at least 8 characters
                    ->mixedCase()             // at least one uppercase & one lowercase
                    ->letters()               // at least one letter
                    ->numbers()               // at least one number
                    ->symbols(),               // at least one special character
                    // ->uncompromised(),        // not found in known leaked password lists
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    // auth/login.blade.php (main)
    public function redirectToGoogle()
    {

        // dd(config('services.google')); //checker kung loaded na yung credentials
        return Socialite::driver('google')->redirect();
    }


    // auth/login.blade.php (main)
    // Pag access blocked - ibig sabihin user are requesting a new token too soon
    // When logging out, Google invalidates the session.
    // If the user tries to log in again immediately, Google may block it temporarily, thinking it's spam.
    // Waiting a few minutes before logging in again usually fixes the issue.
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'profile_pic' => $googleUser->getAvatar(),
                    'password' => Hash::make(str()->random(16)), // Random password
                ]);
            }

            Auth::login($user);
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed.');
        }
    }


    // Logout
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Logged out successfully.')
            ->with('toast', [
                'message' => 'Logged out successfully!',
                'type' => 'success'
            ]);
    }

    // Show forgot password form
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Handle forgot password form
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))->with('toast', [
                'message' => 'Reset link sent to your email.',
                'type' => 'success'
            ])
            : back()->withErrors(['email' => __($status)])->with('toast', [
                'message' => 'Unable to send reset link.',
                'type' => 'error'
            ]);
    }

    // Show reset password form
    public function showResetPassword($token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email')
        ]);
    }

    // Handle reset password form
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)              // at least 8 characters
                    ->mixedCase()             // at least one uppercase & one lowercase
                    ->letters()               // at least one letter
                    ->numbers()               // at least one number
                    ->symbols(),               // at least one special character
                    // ->uncompromised(),        // not found in known leaked password lists
            ],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))->with('toast', [
                'message' => 'Password reset successfully! Please login.',
                'type' => 'success'
            ])
            : back()->withErrors(['email' => [__($status)]])->with('toast', [
                'message' => 'Password reset failed.',
                'type' => 'error'
            ]);
    }

    // Show change password form
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    // Handle change password form
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect'
            ])->with('toast', [
                'message' => 'Current password is incorrect.',
                'type' => 'error'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Password changed successfully!')
            ->with('toast', [
                'message' => 'Password changed successfully!',
                'type' => 'success'
            ]);
    }
}
