<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmbientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_local')->unsigned();
            $table->integer('fk_tipo');
            $table->text('descricao')->nullable();
            $table->integer('numero_ambiente')->nullable();
            $table->string('status');
            $table->foreign('fk_local')->references('id')->on('locais');
            $table->foreign('fk_tipo')->references('id')->on('tipo_ambientes');
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
        Schema::dropIfExists('ambientes');
    }
}
