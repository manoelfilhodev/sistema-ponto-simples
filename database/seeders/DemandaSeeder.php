<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemandaSeeder extends Seeder
{
    public function run(): void
    {
        // tipo (enum 'RECEBIMENTO','EXPEDICAO'...), fo (NOT NULL), status (default 'GERAR')
        $now = now();
        $rows = [
            [
                'fo'            => 'FO-0001',
                'cliente'       => 'Cliente Alpha',
                'transportadora'=> 'Trans XPTO',
                'veiculo'       => 'Caminhão 3/4',
                'modelo_veicular'=> 'VW Delivery',
                'doca'          => 'A1',
                'tipo'          => 'RECEBIMENTO',
                'quantidade'    => 30,
                'motorista'     => 'João Silva',
                'peso'          => 1200.00,
                'valor_carga'   => 150000.00,
                'hora_agendada' => '09:00:00',
                'entrada'       => '08:50:00',
                'saida'         => '10:15:00',
                'status'        => 'GERAR', // seu default
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'fo'            => 'FO-0002',
                'cliente'       => 'Cliente Beta',
                'transportadora'=> 'Trans ACME',
                'veiculo'       => 'VUC',
                'modelo_veicular'=> 'Iveco Daily',
                'doca'          => 'B2',
                'tipo'          => 'EXPEDICAO',
                'quantidade'    => 20,
                'motorista'     => 'Maria Souza',
                'peso'          => 800.00,
                'valor_carga'   => 90000.00,
                'hora_agendada' => '14:00:00',
                'entrada'       => '13:55:00',
                'saida'         => '15:10:00',
                'status'        => 'GERAR',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        DB::table('_tb_demanda')->insert($rows);
        $this->command->info('Demandas inseridas com sucesso.');
    }
}
