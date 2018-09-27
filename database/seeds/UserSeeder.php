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
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'),
			'telefone' => '(73) 3526-7504',
			'endereco' => 'Av. José Moreira Sobrinho numero 12',
			'fk_cidade' => 3387,
            'status' => 1
        ]);
    }
}
