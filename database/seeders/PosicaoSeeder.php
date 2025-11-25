<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosicaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $unidadeId = DB::table('_tb_unidades')->where('nome', 'Unidade Central')->value('id');
    if (!$unidadeId) {
        $unidadeId = DB::table('_tb_unidades')->min('id');
    }

    $makeCodigo = fn($corredor, $prateleira, $nivel) => sprintf('%s-%s-%s', $corredor, $prateleira, $nivel);

    DB::table('_tb_posicoes')->insert([
        [
            'corredor' => 'A',
            'prateleira' => '1',
            'nivel' => '1',
            'capacidade' => 100,
            'tipo_armazenamento' => 'palete',
            'unidade_id' => $unidadeId,
            'codigo_posicao' => $makeCodigo('A', '1', '1'),
        ],
        [
            'corredor' => 'A',
            'prateleira' => '1',
            'nivel' => '2',
            'capacidade' => 100,
            'tipo_armazenamento' => 'palete',
            'unidade_id' => $unidadeId,
            'codigo_posicao' => $makeCodigo('A', '1', '2'),
        ],
        [
            'corredor' => 'B',
            'prateleira' => '2',
            'nivel' => '1',
            'capacidade' => 50,
            'tipo_armazenamento' => 'caixa',
            'unidade_id' => $unidadeId,
            'codigo_posicao' => $makeCodigo('B', '2', '1'),
        ],
    ]);
}
}
