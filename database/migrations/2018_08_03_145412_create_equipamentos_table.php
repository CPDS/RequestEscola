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
            $table->integer('fk_tipo_equipamento');
            $table->integer('fk_local');
            $table->string('num_tombo')->nullable();
            $table->string('codigo');
            $table->string('marca');
            $table->string('status');
            $table->foreign('fk_tipo_equipamento')->references('id')->on('tipo_equipamentos');
            $table->foreign('fk_local')->references('id')->on('locais');
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
