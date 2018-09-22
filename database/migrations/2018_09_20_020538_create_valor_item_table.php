<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValorItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valor_item', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor');
            $table->unsignedInteger('pagamento_id');
            $table->unsignedInteger('item_historico_id');
            $table->foreign('pagamento_id')->references('id')->on('pagamento')->onDelete('cascade');
            $table->foreign('item_historico_id')->references('id')->on('item_historico')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valor_item');
    }
}
