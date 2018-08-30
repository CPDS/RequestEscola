<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlteracoesAmbienteReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alteracoes_ambiente_reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_reserva_ambiente');
            $table->integer('fk_usuario');
            $table->text('descricao');
            $table->foreign('fk_reserva_ambiente')->references('id')->on('ambiente_reservas');
            $table->foreign('fk_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('alteracoes_ambiente_reservas');
    }
}
