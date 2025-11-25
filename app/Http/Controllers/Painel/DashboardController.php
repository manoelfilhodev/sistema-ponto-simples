<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Ponto;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRegistros = Ponto::count();
        $hoje = Ponto::whereDate('data_hora', today())->count();

        return view('painel.dashboard', compact('totalRegistros', 'hoje'));
    }
}
