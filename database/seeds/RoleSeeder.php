<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('roles')->insert([
            'name' => 'Administrador',
            'guard_name' => 'Administrador',
        ]);
         DB::table('roles')->insert([
            'name' => 'Funcionario',
            'guard_name' => 'Funcionario',
         ]);
         DB::table('roles')->insert([
            'name' => 'Professor',
            'guard_name' => 'Professor',
         ]);

    }
}
