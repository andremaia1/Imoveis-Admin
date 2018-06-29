<?php

use Illuminate\Database\Seeder;

class AdministradorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('administrador')->insert([
            'nome' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'telefone' => '99191-9191'
        ]);
    }
}
