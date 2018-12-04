<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multa', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor');
            $table->integer('status');
            $table->date('dataPagamento')->nullable();
            $table->unsignedInteger('locacao_id')->nullable();
            $table->unsignedInteger('pagamento_id')->nullable();
            $table->foreign('locacao_id')->references('id')->on('locacao')->onDelete('cascade');
            $table->foreign('pagamento_id')->references('id')->on('pagamento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multa');
    }
}
