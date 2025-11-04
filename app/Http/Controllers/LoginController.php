<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{ 
    // Show signup form
    public function showSignUp()
    {
        return view('sign-up');
    }

    // Handle signup
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //  Auto login after signup
        Auth::login($user);

        //  Redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.sign-in');
    }

    //  Handle login
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        //  Redirect to dashboard (force)
        return redirect()->route('dashboard')->with('success', 'Welcome back!');
    }

    // ❌ If login fails
    return back()->withErrors([
        'email' => 'Invalid email or password.',
    ])->onlyInput('email');
}

    //  Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}



