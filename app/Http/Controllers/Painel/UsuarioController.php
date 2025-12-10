<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    // ============================================
    // LISTAR USUÁRIOS
    // ============================================
    public function index()
    {
        // Oculta sempre o usuário ID 1 (protegido)
        $usuarios = User::where('id', '!=', 1)
            ->orderBy('name')
            ->get();

        return view('painel.usuarios.index', compact('usuarios'));
    }

    // ============================================
    // FORMULÁRIO DE CRIAÇÃO
    // ============================================
    public function create()
    {
        return view('painel.usuarios.create');
    }

    // ============================================
    // SALVAR NOVO USUÁRIO
    // ============================================
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'     => 'required|string|min:3',
                'email'    => 'required|email|unique:users,email',
                'cpf'      => 'required|string|min:11|max:14|unique:users,cpf',
                'password' => 'required|string|min:6',
                'cargo'    => 'required|string'
            ],
            [
                'name.required'     => 'O nome completo é obrigatório.',
                'name.min'          => 'O nome deve ter pelo menos 3 caracteres.',

                'email.required'    => 'O e-mail é obrigatório.',
                'email.email'       => 'Informe um e-mail válido.',
                'email.unique'      => 'Este e-mail já está cadastrado.',

                'cpf.required'      => 'O CPF é obrigatório.',
                'cpf.min'           => 'O CPF deve ter ao menos 11 caracteres.',
                'cpf.unique'        => 'Este CPF já está cadastrado.',

                'password.required' => 'A senha é obrigatória.',
                'password.min'      => 'A senha deve ter pelo menos 6 caracteres.',

                'cargo.required'    => 'Selecione um nível de acesso.',
            ]
        );

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'cpf'      => $request->cpf,
            'cargo'    => $request->cargo,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    // ============================================
    // EDITAR USUÁRIO
    // ============================================
    public function edit($id)
    {
        if ($id == 1) {
            abort(403, 'Usuário protegido.');
        }

        $usuario = User::findOrFail($id);

        return view('painel.usuarios.edit', compact('usuario'));
    }

    // ============================================
    // ATUALIZAR USUÁRIO
    // ============================================
    public function update(Request $request, $id)
    {
        if ($id == 1) {
            abort(403, 'Usuário protegido.');
        }

        $usuario = User::findOrFail($id);

        $request->validate(
            [
                'name'  => 'required|string|min:3',
                'email' => 'required|email|unique:users,email,' . $id,
                'cpf'   => 'required|string|min:11|max:14|unique:users,cpf,' . $id,
                'cargo' => 'required|string'
            ],
            [
                'name.required'  => 'O nome é obrigatório.',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email'    => 'Informe um e-mail válido.',
                'email.unique'   => 'Este e-mail já está em uso.',

                'cpf.required'   => 'O CPF é obrigatório.',
                'cpf.unique'     => 'Este CPF já está cadastrado.',

                'cargo.required' => 'Selecione um nível de acesso.',
            ]
        );

        $usuario->update([
            'name'  => $request->name,
            'email' => $request->email,
            'cpf'   => $request->cpf,
            'cargo' => $request->cargo
        ]);

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
            $usuario->save();
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    // ============================================
    // EXCLUIR USUÁRIO INDIVIDUAL
    // ============================================
    public function destroy($id)
    {
        if ($id == 1) {
            abort(403, 'Usuário protegido.');
        }

        User::destroy($id);

        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
    }

    // ============================================
    // EXCLUSÃO EM MASSA
    // ============================================
    public function destroyMultiple(Request $request)
    {
        $ids = json_decode($request->ids, true);

        if (!$ids || !is_array($ids)) {
            return back()->with('error', 'Nenhum usuário selecionado.');
        }

        // Impede excluir o próprio usuário
        if (in_array(Auth::id(), $ids)) {
            return back()->with('error', 'Você não pode excluir a si mesmo.');
        }

        // Impede excluir o ID 1
        $ids = array_filter($ids, fn($id) => $id != 1);

        User::whereIn('id', $ids)->delete();

        return back()->with('success', 'Usuários selecionados foram removidos com sucesso!');
    }
}
