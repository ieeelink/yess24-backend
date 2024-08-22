<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validated  = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);

        Auth::attempt($validated);

        return redirect()->route('registrations');

    }
}
