<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmbienteReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambiente_reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_reserva');
            $table->integer('fk_ambiente');
            $table->boolean('tipo');
            $table->string('solicitante')->nullable();
            $table->string('telefone')->nullable();
            $table->boolean('status');
            $table->foreign('fk_reserva')->references('id')->on('reservas');
            $table->foreign('fk_ambiente')->references('id')->on('ambientes');
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
        Schema::dropIfExists('ambiente_reservas');
    }
}
