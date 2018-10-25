<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCondominioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condominio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('imovel_id');
            $table->unsignedInteger('imobiliaria_id');
            $table->foreign('imovel_id')->references('id')->on('imovel');
            $table->foreign('imobiliaria_id')->references('id')->on('imobiliaria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('condominio');
    }
}
