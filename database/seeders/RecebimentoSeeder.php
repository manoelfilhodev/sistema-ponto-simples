<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecebimentoSeeder extends Seeder
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

    private function firstPkValue(string $table, array $preferredWhere = []): ?int
    {
        $pk = $this->pk($table);
        // tenta com where preferencial
        if (!empty($preferredWhere)) {
            $q = DB::table($table)->select($pk);
            foreach ($preferredWhere as $col => $val) {
                if (DB::getSchemaBuilder()->hasColumn($table, $col)) {
                    $q->where($col, $val);
                }
            }
            $row = $q->first();
            if ($row) return (int)$row->{$pk};
        }
        // fallback: primeiro registro
        $row = DB::table($table)->select($pk)->orderBy($pk)->first();
        return $row ? (int)$row->{$pk} : null;
    }

    public function run(): void
    {
        $tRec      = '_tb_recebimento';
        $tRecItens = '_tb_recebimento_itens';

        // PKs
        $usuariosPk = $this->pk('_tb_usuarios');
        $unidadesPk = $this->pk('_tb_unidades');
        $recPk      = $this->pk($tRec);

        // Base
        $unidadeId  = $this->firstPkValue('_tb_unidades', ['nome' => 'Unidade Central']);
        $operadorId = $this->firstPkValue('_tb_usuarios', ['tipo_usuario' => 'operador']); // se a coluna não existir, cai para o primeiro usuário

        if (!$unidadeId || !$operadorId) {
            $this->command->warn('RecebimentoSeeder: unidade/operador não encontrados.');
            return;
        }

        // Materiais (sku pode não existir; usamos fallback)
        $matPk = $this->pk('_tb_materiais');
        $smartphone = DB::table('_tb_materiais')->when(DB::getSchemaBuilder()->hasColumn('_tb_materiais','sku'), function ($q) {
                $q->where('sku', 'SMARTX001');
            })->first();
        $notebook   = DB::table('_tb_materiais')->when(DB::getSchemaBuilder()->hasColumn('_tb_materiais','sku'), function ($q) {
                $q->where('sku', 'NOTEPRO002');
            })->first();

        // Cabeçalho do recebimento
        $recData = [
            'unidade_id'       => $unidadeId,
            'usuario_id'       => $operadorId,         // sua coluna permite NULL, mas vamos gravar
            'status'           => 'conferido',          // enum('pendente','conferido')
            'nota_fiscal'      => 'NF-987654',
            'fornecedor'       => 'Fornecedor XPTO',
            'data_recebimento' => now()->toDateString(), // date
            'created_at'       => now(),
            'updated_at'       => now(),
        ];
        $recId = DB::table($tRec)->insertGetId($recData);

        // Itens: suas colunas obrigatórias: recebimento_id, usuario_id (NOT NULL), unidade_id (NOT NULL)
        $itens = [];

        $i1 = [
            'recebimento_id' => $recId,
            'usuario_id'     => $operadorId,
            'unidade_id'     => $unidadeId,
            'status'         => 'pendente',
            'quantidade'     => 20,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
        // sku/descricao se existirem no material
        $i1['sku']       = $smartphone->sku ?? 'SMARTX001';
        $i1['descricao'] = $smartphone->descricao ?? 'Smartphone de última geração';
        // opcionais
        $i1['valor_unitario'] = 2000.00;
        $i1['valor_total']    = 2000.00 * $i1['quantidade'];
        $itens[] = $i1;

        $i2 = [
            'recebimento_id' => $recId,
            'usuario_id'     => $operadorId,
            'unidade_id'     => $unidadeId,
            'status'         => 'pendente',
            'quantidade'     => 10,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
        $i2['sku']       = $notebook->sku ?? 'NOTEPRO002';
        $i2['descricao'] = $notebook->descricao ?? 'Notebook para profissionais';
        $i2['valor_unitario'] = 6000.00;
        $i2['valor_total']    = 6000.00 * $i2['quantidade'];
        $itens[] = $i2;

        DB::table($tRecItens)->insert($itens);

        $this->command->info('Recebimento e itens inseridos com sucesso.');
    }
}
