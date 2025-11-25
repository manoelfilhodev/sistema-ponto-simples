<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeparacaoItensSeeder extends Seeder
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
        $schema = DB::getSchemaBuilder();
        $cols   = $schema->getColumnListing('_tb_separacao_itens');

        $has = fn(string $c) => in_array($c, $cols, true);

        $unidadeId = $this->firstPkValue('_tb_unidades', ['nome' => 'Unidade Central']);
        $usuarioId = $this->firstPkValue('_tb_usuarios', ['tipo_usuario' => 'separador']);

        if (!$unidadeId || !$usuarioId) {
            $this->command->warn('SeparacaoItensSeeder: unidade/usuario não encontrados.');
            return;
        }

        $seps = DB::table('_tb_separacoes')->whereIn('pedido', ['PED-1001', 'PED-1002'])->get();
        if ($seps->isEmpty()) {
            $this->command->warn('SeparacaoItensSeeder: nenhuma separação encontrada.');
            return;
        }

        $pedidos = DB::table('_tb_pedidos')
            ->whereIn('numero_pedido', ['PED-1001', 'PED-1002'])
            ->get()->keyBy('numero_pedido');

        $makeItem = function ($sep) use ($has, $pedidos, $unidadeId, $usuarioId) {
            // pedido_id é NOT NULL na sua tabela — garantir existência
            $pedido = $pedidos[$sep->pedido] ?? null;
            if (!$pedido) return null;

            $item = [];

            // Obrigatórios
            if ($has('pedido_id'))   $item['pedido_id'] = $pedido->id;   // sua PK de pedidos é id
            if ($has('usuario_id'))  $item['usuario_id'] = $usuarioId;
            if ($has('unidade_id'))  $item['unidade_id'] = $unidadeId;
            if ($has('sku'))         $item['sku'] = $sep->sku;
            if ($has('quantidade'))  $item['quantidade'] = $sep->quantidade;

            // Relacionais/opcionais
            if ($has('separacao_id'))       $item['separacao_id'] = $sep->id;
            if ($has('quantidade_separada')) $item['quantidade_separada'] = min($sep->quantidade, $sep->quantidade);
            if ($has('observacoes'))        $item['observacoes'] = $sep->observacoes;
            if ($has('centro'))             $item['centro'] = 'A1';
            if ($has('fo'))                 $item['fo'] = 'F1';
            if ($has('status'))             $item['status'] = 'ABERTA';
            if ($has('data_separacao'))     $item['data_separacao'] = now();
            if ($has('data_conferencia'))   $item['data_conferencia'] = null;
            if ($has('coletado_por'))       $item['coletado_por'] = $usuarioId;
            if ($has('created_at'))         $item['created_at'] = now();

            // Só adiciona 'confirmado' se a coluna existir
            if ($has('confirmado'))         $item['confirmado'] = 0;

            return $item;
        };

        $payload = [];
        foreach ($seps as $sep) {
            $row = $makeItem($sep);
            if ($row) $payload[] = $row;
        }

        if (empty($payload)) {
            $this->command->warn('SeparacaoItensSeeder: nenhum item válido para inserir.');
            return;
        }

        DB::table('_tb_separacao_itens')->insert($payload);
        $this->command->info('Itens de separação inseridos com sucesso (colunas detectadas dinamicamente).');
    }
}
