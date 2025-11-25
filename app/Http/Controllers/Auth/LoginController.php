<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('painel.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('painel.dashboard');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas']);
    }
}
