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
            $table->integer('id_reserva');
            $table->integer('id_equipamento');
            $table->boolean('status');
            $table->foreign('id_reserva')->references('id')->on('reservas');
            $table->foreign('id_equipamento')->references('id')->on('equipamentos');
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
