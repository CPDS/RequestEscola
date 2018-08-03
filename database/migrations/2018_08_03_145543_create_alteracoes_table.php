<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlteracoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alteracoes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_reserva_equipamento');
            $table->integer('id_usuario');
            $table->text('descricao');
            $table->foreign('id_reserva_equipamento')->references('id')->on('equipamento_reservas');
            $table->foreign('id_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('alteracoes');
    }
}
