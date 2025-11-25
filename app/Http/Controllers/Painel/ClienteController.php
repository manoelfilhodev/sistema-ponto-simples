<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('painel.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('painel.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required']);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit(Cliente $cliente)
    {
        return view('painel.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return back()->with('success', 'Cliente removido.');
    }
}
