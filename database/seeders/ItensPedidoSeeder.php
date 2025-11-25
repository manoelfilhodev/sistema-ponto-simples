<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItensPedidoSeeder extends Seeder
{
    public function run(): void
    {
        $pedido1 = DB::table('_tb_pedidos')->where('numero_pedido', 'PED-1001')->first();
        $pedido2 = DB::table('_tb_pedidos')->where('numero_pedido', 'PED-1002')->first();

        $smartphone = DB::table('_tb_materiais')->where('sku', 'SMARTX001')->first();
        $notebook   = DB::table('_tb_materiais')->where('sku', 'NOTEPRO002')->first();

        if (!$pedido1 || !$pedido2 || !$smartphone || !$notebook) {
            $this->command->warn('ItensPedidoSeeder: faltam pedidos ou materiais.');
            return;
        }

        DB::table('_tb_pedidos_itens')->insert([
            [
                'pedido_id'     => $pedido1->id,
                'material_id'   => $smartphone->id,
                'quantidade'    => 10,
                'preco_unitario'=> 2500.00,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'pedido_id'     => $pedido1->id,
                'material_id'   => $notebook->id,
                'quantidade'    => 5,
                'preco_unitario'=> 6500.00,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'pedido_id'     => $pedido2->id,
                'material_id'   => $smartphone->id,
                'quantidade'    => 3,
                'preco_unitario'=> 2550.00,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
