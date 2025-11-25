<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeparacaoSeeder extends Seeder
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
            if (DB::getSchemaBuilder()->hasColumn($table, $col)) $q->where($col, $val);
        }
        $row = $q->first();
        if (!$row) $row = DB::table($table)->select($pk)->orderBy($pk)->first();
        return $row ? (int)$row->{$pk} : null;
    }

    public function run(): void
    {
        // Bases
        $unidadeId = $this->firstPkValue('_tb_unidades', ['nome' => 'Unidade Central']);
        $usuarioId = $this->firstPkValue('_tb_usuarios', ['tipo_usuario' => 'separador']); // cai para o primeiro se não existir

        if (!$unidadeId || !$usuarioId) {
            $this->command->warn('SeparacaoSeeder: unidade/usuario não encontrados.');
            return;
        }

        // Pega pedidos inseridos anteriormente
        $p1 = DB::table('_tb_pedidos')->where('numero_pedido', 'PED-1001')->first();
        $p2 = DB::table('_tb_pedidos')->where('numero_pedido', 'PED-1002')->first();
        if (!$p1 || !$p2) {
            $this->command->warn('SeparacaoSeeder: pedidos PED-1001/1002 não encontrados.');
            return;
        }

        // Cria separações (campos obrigatórios: pedido (varchar), sku (varchar), quantidade (int), endereco (varchar), usuario_id, unidade_id, data_separacao tem default)
        $sepRows = [
            [
                'pedido_id'     => $p1->id ?? null,       // sua tabela aceita NULL
                'pedido'        => $p1->numero_pedido,    // obrigatório
                'sku'           => 'SMARTX001',           // obrigatório
                'quantidade'    => 5,                     // obrigatório
                'endereco'      => 'A-1-1',               // obrigatório
                'usuario_id'    => $usuarioId,
                'unidade_id'    => $unidadeId,
                'observacoes'   => 'Separar com prioridade',
                'data_separacao'=> now(),
            ],
            [
                'pedido_id'     => $p1->id ?? null,
                'pedido'        => $p1->numero_pedido,
                'sku'           => 'NOTEPRO002',
                'quantidade'    => 3,
                'endereco'      => 'A-1-2',
                'usuario_id'    => $usuarioId,
                'unidade_id'    => $unidadeId,
                'observacoes'   => null,
                'data_separacao'=> now(),
            ],
            [
                'pedido_id'     => $p2->id ?? null,
                'pedido'        => $p2->numero_pedido,
                'sku'           => 'SMARTX001',
                'quantidade'    => 2,
                'endereco'      => 'A-1-1',
                'usuario_id'    => $usuarioId,
                'unidade_id'    => $unidadeId,
                'observacoes'   => null,
                'data_separacao'=> now(),
            ],
        ];

        DB::table('_tb_separacoes')->insert($sepRows);

        $this->command->info('Separações inseridas com sucesso.');
    }
}
