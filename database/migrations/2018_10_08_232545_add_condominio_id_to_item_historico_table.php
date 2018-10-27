<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCondominioIdToItemHistoricoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_historico', function (Blueprint $table) {
            $table->unsignedInteger('condominio_id')->nullable();
            $table->foreign('condominio_id')->references('id')->on('condominio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_historico', function (Blueprint $table) {
            //
        });
    }
}
