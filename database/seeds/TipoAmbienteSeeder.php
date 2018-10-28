<?php

use Illuminate\Database\Seeder;
use App\TipoAmbiente;

class TipoAmbienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAmbiente::create( [
            'nome'  =>    'Sala',
            'descricao' => 'Sala de aula',
            'status'  =>  true
        ]);

        TipoAmbiente::create( [
            'nome'  =>    'Laboratorio',
            'descricao' => 'Laboratorio de aula',
            'status'  =>  true
        ]);

        TipoAmbiente::create( [
            'nome'  =>    'Pavilhão',
            'descricao' => 'Pavilhão para apreserntaçõe',
            'status'  =>  true
        ]);
    }
}
