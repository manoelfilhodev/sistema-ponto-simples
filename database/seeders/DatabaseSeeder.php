<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UnidadeSeeder::class,
            CategoriaSeeder::class,
            UsuarioSeeder::class,
            MaterialSeeder::class,
            PosicaoSeeder::class,
            SaldoEstoqueSeeder::class,
            PedidoSeeder::class,
            RecebimentoSeeder::class,
            SeparacaoSeeder::class,
            DemandaSeeder::class,
            InventarioSeeder::class,
        ]);
    }
}