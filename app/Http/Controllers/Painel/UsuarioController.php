<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('cliente')->get();
        return view('painel.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('painel.usuarios.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|unique:_tb_users',
            'senha' => 'required',
        ]);

        User::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
            'cliente_id' => $request->cliente_id
        ]);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $usuario)
    {
        $clientes = Cliente::all();
        return view('painel.usuarios.edit', compact('usuario', 'clientes'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required',
        ]);

        $usuario->update([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'cliente_id' => $request->cliente_id,
        ]);

        if ($request->filled('senha')) {
            $usuario->update([
                'senha' => Hash::make($request->senha)
            ]);
        }

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuário atualizado!');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return back()->with('success', 'Usuário removido.');
    }
}
