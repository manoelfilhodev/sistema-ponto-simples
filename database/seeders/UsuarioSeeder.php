<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
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

    DB::table('_tb_usuarios')->insert([
        [
            'nome' => 'Admin User',
            'email' => 'admin@wms.com',
            'password' => bcrypt('admin123'),
            'tipo_usuario' => 'admin',
            'status' => 'ativo',
            'unidade_id' => $unidadeId,
        ],
        [
            'nome' => 'Operador 1',
            'email' => 'operador1@wms.com',
            'password' => bcrypt('operador123'),
            'tipo_usuario' => 'operador',
            'status' => 'ativo',
            'unidade_id' => $unidadeId,
        ],
        [
            'nome' => 'Gerente 1',
            'email' => 'gerente1@wms.com',
            'password' => bcrypt('gerente123'),
            'tipo_usuario' => 'gerente',
            'status' => 'ativo',
            'unidade_id' => $unidadeId,
        ],
    ]);
}
}
