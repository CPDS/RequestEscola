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
            $table->integer('fk_ambiente');
            $table->timestamp('data_inicial');
            $table->timestamp('data_final');
            $table->text('parecer');
            $table->text('observacao')->nullable();
            $table->text('feedback')->nullable();
            $table->string('status');
            $table->foreign('fk_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('reservas');
    }
}
