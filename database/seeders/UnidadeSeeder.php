<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('_tb_unidades')->insert([
            ['nome' => 'Unidade Central', 'endereco' => 'Rua Principal, 123', 'cidade' => 'São Paulo', 'estado' => 'SP', 'cep' => '01000-000', 'telefone' => '11987654321', 'email' => 'central@wms.com'],
            ['nome' => 'Unidade Secundária', 'endereco' => 'Av. Secundária, 456', 'cidade' => 'Rio de Janeiro', 'estado' => 'RJ', 'cep' => '20000-000', 'telefone' => '21912345678', 'email' => 'secundaria@wms.com'],
        ]);
    }
}