<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'cpf' => 'required',
            'senha' => 'required',
        ]);

        if (Auth::attempt([
            'cpf' => $request->cpf,
            'senha' => $request->senha
        ])) {
            return redirect()->route('painel.dashboard');
        }

        return back()->with('error', 'CPF ou senha incorretos.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
