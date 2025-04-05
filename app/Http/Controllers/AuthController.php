<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    // Show login & register page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle manual login
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

    // Handle manual registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    // Redirect to Google
    public function redirectToGoogle()
    {
        
        // dd(config('services.google')); //checker kung loaded na yung credentials
        return Socialite::driver('google')->redirect();
    }


    // Handle Google callback
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
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

}
