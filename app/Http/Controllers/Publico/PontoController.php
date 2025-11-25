<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ponto;
use Illuminate\Http\Request;

class PontoController extends Controller
{

    public function bater()
    {
        return view('ponto.bater-cpf');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'cpf'         => 'required',
            'tipo'        => 'required|in:entrada,saida',
            'foto_base64' => 'required'
        ]);

        $user = User::where('cpf', $request->cpf)->first();

        if (!$user) {
            return back()->with('error', 'CPF não encontrado.');
        }

        // --- Salvar Foto ---
        $fotoNome = 'ponto_' . $user->cpf . '_' . time() . '.jpg';
        $caminho  = public_path('fotos_ponto/' . $fotoNome);

        if (!is_dir(public_path('fotos_ponto'))) {
            mkdir(public_path('fotos_ponto'), 0777, true);
        }

        file_put_contents($caminho, base64_decode($request->foto_base64));


        // --- Criar Registro ---
        Ponto::create([
            'user_id'   => $user->id,
            'tipo'      => $request->tipo,
            'foto'      => $fotoNome,
            'lat'       => $request->lat,
            'lng'       => $request->lng,
            'origem'    => 'web',
            'data_hora' => now(),
        ]);

        return redirect()->route('ponto.sucesso')
            ->with('success', 'Ponto registrado com sucesso!');
    }

    public function sucesso()
    {
        return view('ponto.sucesso');
    }
}
