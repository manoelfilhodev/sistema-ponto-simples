<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ==============================
    // LISTAGEM
    // ==============================
    public function index()
    {
        // Verifica se é admin
        if (session('tipo') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acesso não autorizado!');
        }

        // Lista todos os usuários exceto o admin
        $usuarios = User::where('email', '!=', 'admin@systex.com.br')
            ->orderBy('name')
            ->get();

        return view('usuarios.index', compact('usuarios'));
    }

    // ==============================
    // FORM DE CRIAÇÃO
    // ==============================
    public function create()
    {
        return view('usuarios.create');
    }

    // ==============================
    // SALVAR NOVO USUÁRIO
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6',
            'cpf'       => 'required|string|max:14|unique:users,cpf',
            'cargo'     => 'nullable|string|max:255',
            'cliente_id'=> 'nullable|integer',
            'ativo'     => 'required|boolean',
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'cpf'           => $request->cpf,
            'cargo'         => $request->cargo,
            'cliente_id'    => $request->cliente_id,
            'foto'          => $request->foto ?? null,
            'ativo'         => $request->ativo,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    // ==============================
    // FORM DE EDIÇÃO
    // ==============================
    public function edit($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return redirect()->route('usuarios.index')->with('error', 'Usuário não encontrado.');
        }

        return view('usuarios.edit', compact('usuario'));
    }

    // ==============================
    // ATUALIZAR USUÁRIO
    // ==============================
    public function update(Request $request, $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return redirect()->route('usuarios.index')->with('error', 'Usuário não encontrado.');
        }

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $id,
            'cpf'       => 'required|string|max:14|unique:users,cpf,' . $id,
            'cargo'     => 'nullable|string|max:255',
            'cliente_id'=> 'nullable|integer',
            'ativo'     => 'required|boolean',
        ]);

        $usuario->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'cpf'           => $request->cpf,
            'cargo'         => $request->cargo,
            'cliente_id'    => $request->cliente_id,
            'ativo'         => $request->ativo,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    // ==============================
    // EXCLUIR USUÁRIO
    // ==============================
    public function destroy($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return redirect()->route('usuarios.index')->with('error', 'Usuário não encontrado.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
