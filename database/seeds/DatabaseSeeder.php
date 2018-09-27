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
        $this->call(EstadosSeeder::class);
        $this->call(CidadesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RolesAndPermissions::class);
        $this->call(ModelRolesSeeder::class);
       
    }
}
