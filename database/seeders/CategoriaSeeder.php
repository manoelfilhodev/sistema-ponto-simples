<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('_tb_categorias')->insert([
            ['nome' => 'Eletrônicos', 'descricao' => 'Produtos eletrônicos em geral'],
            ['nome' => 'Alimentos', 'descricao' => 'Produtos alimentícios não perecíveis'],
            ['nome' => 'Limpeza', 'descricao' => 'Produtos de limpeza doméstica'],
            ['nome' => 'Vestuário', 'descricao' => 'Roupas e acessórios'],
        ]);
    }
}
