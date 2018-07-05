<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocatarioIdToLocacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locacao', function (Blueprint $table) {
            $table->unsignedInteger('locatario_id');
            $table->foreign('locatario_id')->references('id')->on('locatario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locacao', function (Blueprint $table) {
            //
        });
    }
}
