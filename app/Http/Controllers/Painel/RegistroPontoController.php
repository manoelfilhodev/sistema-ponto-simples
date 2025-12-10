<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Ponto;
use App\Models\User;
use Illuminate\Http\Request;

class RegistroPontoController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = User::orderBy('name')->get();

        $registros = Ponto::with('user')
            ->when($request->usuario_id, fn ($q) =>
                $q->where('user_id', $request->usuario_id)
            )
            ->when($request->tipo, fn ($q) =>
                $q->where('tipo', $request->tipo)
            )
            ->when($request->data_inicio, fn ($q) =>
                $q->whereDate('data_hora', '>=', $request->data_inicio)
            )
            ->when($request->data_fim, fn ($q) =>
                $q->whereDate('data_hora', '<=', $request->data_fim)
            )
            ->orderBy('data_hora', 'desc')
            ->paginate(20)
            ->appends($request->query());

        return view('registros.index', compact('registros', 'usuarios'));
    }

    public function show(Ponto $registro)
    {
        return view('registros.show', compact('registro'));
    }
}
