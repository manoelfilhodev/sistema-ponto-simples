<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    public function run(): void
    {
        $unidadeId = DB::table('_tb_unidades')->where('nome', 'Unidade Central')->value('id') ?? DB::table('_tb_unidades')->min('id');
        $responsavelId = DB::table('_tb_usuarios')->where('tipo_usuario', 'gerente')->value('id') ?? DB::table('_tb_usuarios')->min('id');

        $invId = DB::table('_tb_contagem_global')->insertGetId([
            'unidade_id'        => $unidadeId,
            'codigo_inventario' => 'INV-2025-01',
            'status'            => 'em_contagem',
            'responsavel_id'    => $responsavelId,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $materiais = DB::table('_tb_materiais')->limit(3)->get();
        foreach ($materiais as $m) {
            DB::table('_tb_inventario_itens')->insert([
                'inventario_id'      => $invId,
                'material_id'        => $m->id,
                'quantidade_sistema' => 100,
                'quantidade_contada' => 98,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }
}
