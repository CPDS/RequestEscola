<?php

use Illuminate\Database\Seeder;
use App\Equipamentos;
class EquipamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Equipamentos::create([
            'nome' => 'Notebook dell',
            'fk_tipo_equipamento' => 1,
            'fk_local' => 1,
            'codigo' => 'as-123',
            'marca' => 'dell',
            'status' => 'Ativo'
        ]);

        Equipamentos::create([
            'nome' => 'Pc Positivo',
            'fk_tipo_equipamento' => 2,
            'fk_local' => 1,
            'num_tombo' => '123.123',
            'codigo' => 'ab-123',
            'marca' => 'Positivo',
            'status' => 'Ativo'
        ]);
    }
}
