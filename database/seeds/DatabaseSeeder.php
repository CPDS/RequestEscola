<?php

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
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'),
			'funcao' =>	'Administrador',
			'telefone' => '(73) 3526-7504',
			'rua' => 'Av. José Moreira Sobrinho',
			'numero' => 12,
			'cidade' => 'Jequié',
			'estado' => 'Bahia',
            'status' => 1,
        ]);
    }
}
