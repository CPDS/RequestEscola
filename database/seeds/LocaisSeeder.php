<?php

use Illuminate\Database\Seeder;
use App\Locais;

class LocaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Locais::create( [
            'nome'  =>    'Audio Visual',
            'observacao' => 'Audio Visual do CEEP',
            'status'  =>  true
        ]);
    }
}
