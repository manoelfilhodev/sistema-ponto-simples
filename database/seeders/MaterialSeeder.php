<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
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

    DB::table('_tb_materiais')->insert([
        [
            'nome' => 'Smartphone X',
            'descricao' => 'Smartphone de última geração',
            'sku' => 'SMARTX001',
            'categoria_id' => 1,
            'unidade_medida' => 'un',
            'status' => 'ativo',
            'unidade_id' => $unidadeId,
        ],
        [
            'nome' => 'Notebook Pro',
            'descricao' => 'Notebook para profissionais',
            'sku' => 'NOTEPRO002',
            'categoria_id' => 1,
            'unidade_medida' => 'un',
            'status' => 'ativo',
            'unidade_id' => $unidadeId,
        ],
        [
            'nome' => 'Arroz Integral 1kg',
            'descricao' => 'Arroz integral orgânico',
            'sku' => 'ARROZINT003',
            'categoria_id' => 2,
            'unidade_medida' => 'kg',
            'status' => 'ativo',
            'unidade_id' => $unidadeId,
        ],
        [
            'nome' => 'Feijão Preto 500g',
            'descricao' => 'Feijão preto selecionado',
            'sku' => 'FEIJAOPR004',
            'categoria_id' => 2,
            'unidade_medida' => 'kg',
            'status' => 'ativo',
            'unidade_id' => $unidadeId,
        ],
    ]);
}
}
