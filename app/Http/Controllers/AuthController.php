<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show signup form
    public function showSignUp()
    {
        return view('auth.sign-up');  
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => 'User',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/dashboard')->with('success', 'Account created successfully!');
    }
}
