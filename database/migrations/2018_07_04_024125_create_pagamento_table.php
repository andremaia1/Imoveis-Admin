<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamento', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor_total');
            $table->date('dataVencimento');
            $table->date('dataPagamento')->nullable();
            $table->integer('status');
            $table->unsignedInteger('locacao_id');
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
        Schema::dropIfExists('pagamento');
    }
}
