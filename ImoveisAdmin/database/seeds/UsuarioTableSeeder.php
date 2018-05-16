<?php

use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->insert([
            'nome' => 'André',
            'email' => 'andre@gmail.com',
            'password' => bcrypt('456123'),
            'telefone' => '99191-9191',
            'ativo' => 1
        ]);
    }
}
