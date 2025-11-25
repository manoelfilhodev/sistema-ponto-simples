<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaldoEstoqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $unidadeId = DB::table('_tb_unidades')->where('nome', 'Unidade Central')->value('id') ?? DB::table('_tb_unidades')->min('id');

    // Busque materiais por SKU
    $smartphone = DB::table('_tb_materiais')->where('sku', 'SMARTX001')->first();
    $notebook   = DB::table('_tb_materiais')->where('sku', 'NOTEPRO002')->first();

    // Busque posições
    $a11 = DB::table('_tb_posicoes')->where('corredor','A')->where('prateleira','1')->where('nivel','1')->first();
    $a12 = DB::table('_tb_posicoes')->where('corredor','A')->where('prateleira','1')->where('nivel','2')->first();

    // Garantias básicas
    if (!$unidadeId || !$smartphone || !$notebook || !$a11 || !$a12) {
        throw new \RuntimeException('Dados base ausentes: verifique unidades, materiais (SKUs) e posições.');
    }

    $now = now();

    DB::table('_tb_saldo_estoque')->insert([
        [
            'unidade_id'  => $unidadeId,
            'material_id' => $smartphone->id,
            'sku_id'      => $smartphone->id, // ajuste aqui se sku_id referenciar outra tabela
            'posicao_id'  => $a11->id,
            'quantidade'  => 50,
            'data_entrada'=> $now,
        ],
        [
            'unidade_id'  => $unidadeId,
            'material_id' => $notebook->id,
            'sku_id'      => $notebook->id, // ajuste aqui se necessário
            'posicao_id'  => $a12->id,
            'quantidade'  => 30,
            'data_entrada'=> $now,
        ],
    ]);
}
}
