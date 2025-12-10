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
            'email'    => 'required|string',
            'password' => 'required|string'
        ]);

        $credenciais = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        // TENTA AUTENTICAR
        if (Auth::attempt($credenciais)) {

            // Se usuário estiver inativo (se quiser usar)
            /*
            if (!Auth::user()->ativo) {
                Auth::logout();
                return back()->with('error', 'Usuário inativo. Contate o administrador.');
            }
            */

            // ADMIN → vai para o painel
            if (Auth::user()->cargo === 'Administrador') {
                return redirect()->route('painel.dashboard');
            }

            // NÃO ADMIN → vai para página de acesso restrito
            return redirect()->route('acesso.restrito');
        }

        return back()->with('error', 'Credenciais inválidas. Verifique seus dados.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Você saiu do sistema.');
    }
}
