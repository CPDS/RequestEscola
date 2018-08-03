<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('id_tipo_equipamento');
            $table->integer('id_local');
            $table->string('num_tombo')->nullable();
            $table->string('codigo');
            $table->string('marca');
            $table->string('status');
            $table->foreign('id_tipo_equipamento')->references('id')->on('tipo_equipamentos');
            $table->foreign('id_local')->references('id')->on('locais');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipamentos');
    }
}
