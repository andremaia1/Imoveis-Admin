<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemHistoricoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_historico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_item');
            $table->unsignedInteger('locacao_id')->nullable();
            $table->foreign('locacao_id')->references('id')->on('locacao')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_historico');
    }
}
