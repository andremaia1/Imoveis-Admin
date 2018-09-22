<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacao', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor');
            $table->date('inicioContrato');
            $table->date('ultimaRenovacao')->nullable();
            $table->unsignedInteger('imovel_id');
            $table->foreign('imovel_id')->references('id')->on('imovel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locacao');
    }
}
