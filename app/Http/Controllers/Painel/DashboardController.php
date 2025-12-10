<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ponto;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Quantidade de batidas hoje
        $batidasHoje = Ponto::whereDate('data_hora', Carbon::today())->count();

        // Usuários ativos (campo ativo = 1)
        $usuariosAtivos = User::where('ativo', 1)->count();

        // Registros no mês atual
        $registrosMes = Ponto::whereMonth('data_hora', Carbon::now()->month)
                             ->whereYear('data_hora', Carbon::now()->year)
                             ->count();

        return view('painel.dashboard', compact(
            'batidasHoje',
            'usuariosAtivos',
            'registrosMes'
        ));
    }
}
