<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManutencoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('manutencoes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->text('descricao');
            $table->string('destino');
            $table->integer('id_usuario');
            $table->integer('id_equipamento');
            $table->string('status');
            $table->foreign('id_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('manutencoes');
    }
}
