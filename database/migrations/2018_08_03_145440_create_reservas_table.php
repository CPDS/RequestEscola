<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_usuario');
            $table->timestamp('data_inicial');
            $table->timestamp('data_final');
            $table->timestamp('data_hora_retirada')->nullable();
            $table->timestamp('data_hora_entrega')->nullable();
            $table->integer('fk_reserva_externa')->nullable();
            $table->integer('fk_usuario_retirada')->nullable();
            $table->integer('fk_usuario_entrega')->nullable();
            $table->string('solicitante');
            $table->string('solicitante_telefone');
            $table->text('parecer')->nullable();
            $table->text('observacao')->nullable();
            $table->text('feedback')->nullable();
            $table->string('status')->default('Ativo');
            $table->foreign('fk_usuario')->references('id')->on('users');
            $table->foreign('fk_usuario_retirada')->references('id')->on('users');
            $table->foreign('fk_usuario_entrega')->references('id')->on('users');
            $table->foreign('fk_reserva_externa')->references('id')->on('reserva_externas');
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
        Schema::dropIfExists('reservas');
    }
}
