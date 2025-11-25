<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    private function pk(string $table): string
    {
        $row = DB::selectOne("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND CONSTRAINT_NAME = 'PRIMARY'
            LIMIT 1
        ", [$table]);

        return $row ? $row->COLUMN_NAME : 'id';
    }

    private function firstPkValue(string $table, array $where = []): ?int
    {
        $pk = $this->pk($table);
        $q = DB::table($table)->select($pk);
        foreach ($where as $col => $val) {
            $q->where($col, $val);
        }
        $row = $q->first();
        if (!$row) {
            // fallback: primeiro registro
            $row = DB::table($table)->select($pk)->orderBy($pk)->first();
        }
        return $row ? (int)$row->{$pk} : null;
    }

    public function run(): void
    {
        // Tabelas e PKs
        $pedidosTable = '_tb_pedidos';
        $materiaisTable = '_tb_materiais';

        $matPk = $this->pk($materiaisTable);

        // IDs base
        $unidadeId = $this->firstPkValue('_tb_unidades', ['nome' => 'Unidade Central']);
        $usuarioId = $this->firstPkValue('_tb_usuarios', ['tipo_usuario' => 'admin']); // se não existir, cai para o primeiro

        // Materiais por SKU
        $smartphone = DB::table($materiaisTable)->where('sku', 'SMARTX001')->first();
        $notebook   = DB::table($materiaisTable)->where('sku', 'NOTEPRO002')->first();

        if (!$unidadeId || !$usuarioId || !$smartphone || !$notebook) {
            $this->command->warn('PedidoSeeder: dados base ausentes (unidade/usuario/materiais).');
            return;
        }

        // Inserir pedidos usando exatamente as colunas que você mostrou
        $p1 = [
            'numero_pedido' => 'PED-1001',
            'unidade_id'    => $unidadeId,
            'status'        => 'pendente',
            'criado_por'    => $usuarioId,
            // data_criacao vem por default CURRENT_TIMESTAMP
        ];
        $p2 = [
            'numero_pedido' => 'PED-1002',
            'unidade_id'    => $unidadeId,
            'status'        => 'pendente',
            'criado_por'    => $usuarioId,
        ];

        DB::table($pedidosTable)->insert([$p1, $p2]);

        // Se você já criou _tb_pedidos_itens, podemos popular itens aqui também.
        if (DB::getSchemaBuilder()->hasTable('_tb_pedidos_itens')) {
            $pedido1 = DB::table($pedidosTable)->where('numero_pedido', 'PED-1001')->first();
            $pedido2 = DB::table($pedidosTable)->where('numero_pedido', 'PED-1002')->first();

            if ($pedido1 && $pedido2) {
                DB::table('_tb_pedidos_itens')->insert([
                    [
                        'pedido_id'    => $pedido1->id,                 // aqui sua PK é id em _tb_pedidos
                        'material_id'  => $smartphone->{$matPk},
                        'quantidade'   => 10,
                        'preco_unitario'=> 2500.00,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ],
                    [
                        'pedido_id'    => $pedido1->id,
                        'material_id'  => $notebook->{$matPk},
                        'quantidade'   => 5,
                        'preco_unitario'=> 6500.00,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ],
                    [
                        'pedido_id'    => $pedido2->id,
                        'material_id'  => $smartphone->{$matPk},
                        'quantidade'   => 3,
                        'preco_unitario'=> 2550.00,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ],
                ]);
            }
        }
    }
}
