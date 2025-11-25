<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContagemGlobalSeeder extends Seeder
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
        if (!empty($preferredWhere)) {
            $q = DB::table($table)->select($pk);
            foreach ($preferredWhere as $col => $val) {
                if (DB::getSchemaBuilder()->hasColumn($table, $col)) $q->where($col, $val);
            }
            $row = $q->first();
            if ($row) return (int)$row->{$pk};
        }
        $row = DB::table($table)->select($pk)->orderBy($pk)->first();
        return $row ? (int)$row->{$pk} : null;
    }

    public function run(): void
    {
        $unidadeId = $this->firstPkValue('_tb_unidades', ['nome' => 'Unidade Central']);
        $usuarioId = $this->firstPkValue('_tb_usuarios', ['tipo_usuario' => 'inventariante']); // cai para primeiro se não existir

        if (!$unidadeId || !$usuarioId) {
            $this->command->warn('ContagemGlobalSeeder: unidade/usuario não encontrados.');
            return;
        }

        $matPk = $this->pk('_tb_materiais');

        // Pegamos 2 materiais por SKU se existir; senão, os dois primeiros
        $smartphone = DB::table('_tb_materiais')
            ->when(DB::getSchemaBuilder()->hasColumn('_tb_materiais', 'sku'), fn($q) => $q->where('sku', 'SMARTX001'))
            ->first();
        $notebook = DB::table('_tb_materiais')
            ->when(DB::getSchemaBuilder()->hasColumn('_tb_materiais', 'sku'), fn($q) => $q->where('sku', 'NOTEPRO002'))
            ->first();

        if (!$smartphone || !$notebook) {
            $mats = DB::table('_tb_materiais')->select($matPk)->limit(2)->get();
            if ($mats->count() < 2) {
                $this->command->warn('ContagemGlobalSeeder: materiais insuficientes para contagem.');
                return;
            }
            $smartphone = $mats[0];
            $notebook   = $mats[1];
        }

        $rows = [
            [
                'unidade_id'         => $unidadeId,
                'material_id'        => $smartphone->{$matPk},
                'tipo_contagem'      => '1contagem',
                'quantidade_contada' => 100,
                'usuario_id'         => $usuarioId,
                'data_contagem'      => now(),
            ],
            [
                'unidade_id'         => $unidadeId,
                'material_id'        => $notebook->{$matPk},
                'tipo_contagem'      => '1contagem',
                'quantidade_contada' => 50,
                'usuario_id'         => $usuarioId,
                'data_contagem'      => now(),
            ],
            [
                'unidade_id'         => $unidadeId,
                'material_id'        => $smartphone->{$matPk},
                'tipo_contagem'      => '2contagem',
                'quantidade_contada' => 98,
                'usuario_id'         => $usuarioId,
                'data_contagem'      => now(),
            ],
        ];

        DB::table('_tb_contagem_global')->insert($rows);
        $this->command->info('Contagens globais inseridas com sucesso.');
    }
}
