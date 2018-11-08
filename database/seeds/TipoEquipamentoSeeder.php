<?php

use Illuminate\Database\Seeder;
use App\TipoEquipamentos;

class TipoEquipamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoEquipamentos::create([
            'nome' => 'Notebook',
            'observacao' => 'Notebook para uso interno',
            'status' => 'Ativo'
        ]);
        TipoEquipamentos::create([
            'nome' => 'Pc Desktop',
            'observacao' => 'Uso restrito à secretarias',
            'status' => 'Ativo'
        ]);
    }
}
