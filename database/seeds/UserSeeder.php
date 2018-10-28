<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'name' => 'Administrador do Sistema',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'),
			'telefone' => '(73) 3526-7504',
			'endereco' => 'Av. José Moreira Sobrinho numero 12',
			'fk_cidade' => 3387,
            'status' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'Geneses dos Santos Lopes',
            'email' => 'genesesslopes@gmail.com',
            'password' => Hash::make('123123'),
			'telefone' => '(75) 98248-1405',
			'endereco' => 'Av. José Moreira Sobrinho numero 12',
			'fk_cidade' => 3387,
            'status' => 1
        ]);
    }
}
