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
            $table->integer('id_usuario');
            $table->integer('id_sala');
            $table->timestamp('data_inicial');
            $table->timestamp('data_final');
            $table->text('parecer');
            $table->text('observacao')->nullable();
            $table->text('feedback')->nullable();
            $table->string('status');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_sala')->references('id')->on('salas');
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
