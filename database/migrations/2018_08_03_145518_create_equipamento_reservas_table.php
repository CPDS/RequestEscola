<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipamentoReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('equipamento_reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_reserva');
            $table->integer('fk_equipamento');
            $table->string('status')->default('Ativo');
            $table->foreign('fk_reserva')->references('id')->on('reservas');
            $table->foreign('fk_equipamento')->references('id')->on('equipamentos');
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
        Schema::dropIfExists('equipamento_reservas');
    }
}
