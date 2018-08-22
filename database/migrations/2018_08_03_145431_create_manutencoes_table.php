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
            $table->integer('fk_usuario');
            $table->integer('fk_equipamento');
            $table->string('status');
            $table->foreign('fk_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('manutencoes');
    }
}
