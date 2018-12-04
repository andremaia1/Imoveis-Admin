<?php

use Illuminate\Database\Seeder;

class ImovelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('endereco')->insert([
            'numero' => 27,
            'logradouro' => 'Rua Sarandi',
            'bairro_distrito' => 'Laranjal',
            'cidade_id' => 4314407
        ]);
        
        DB::table('imovel')->insert([
            'nome_apelido' => 'Casa do Laranjal',
            'descricao' => 'Casa com 3 quartos, 2 banheiros, sala, cozinha, garagem e piscina na rua Sarandi.',
            'tipo' => 1,
            'status' => 3,
            'areaConstr' => 80,
            'areaTotal' => 300,
            'dataCompra' => date('2018-06-01'),
            'usuario_id' => 1,
            'endereco_id' => 1
        ]);
        
        DB::table('endereco')->insert([
            'numero' => 450,
            'logradouro' => 'Estrada do Quilombo',
            'bairro_distrito' => 'Quilombo (7º distrito)',
            'cidade_id' => 4314407
        ]);
        
        DB::table('imovel')->insert([
            'nome_apelido' => 'Chácara na colônia',
            'descricao' => 'Chácara de 3 hec no Bachini, contendo uma casa, um galpão, arroio e mata nativa.',
            'tipo' => 3,
            'status' => 1,
            'areaConstr' => 100,
            'areaTotal' => 30000,
            'dataCompra' => date('2018-07-10'),
            'usuario_id' => 1,
            'endereco_id' => 2
        ]);
    }
}
