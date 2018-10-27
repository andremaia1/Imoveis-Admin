<?php

use Illuminate\Database\Seeder;

class LocacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fiador')->insert([
            'nome' => 'Pedro',
            'email' => 'pedro@gmail.com',
            'telefone' => '99393-9393',
            'cpf' => '555.444.33-22',
            'rg' => '9876543210'
        ]);
        
        DB::table('locatario')->insert([
            'nome' => 'Paulo',
            'email' => 'paulo@gmail.com',
            'telefone' => '99292-9292',
            'cpf' => '444.333.22-11',
            'rg' => '0123456789',
            'fiador_id' => 1
        ]);
        
        DB::table('locacao')->insert([
            'valor' => 700,
            'inicioContrato' => '2018-08-01',
            'ultimaRenovacao' => null,
            'prazoMinContrato' => 12,
            'imovel_id' => 1,
            'locatario_id' => 1
        ]);
    }
}
