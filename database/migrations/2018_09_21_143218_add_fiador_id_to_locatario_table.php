<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiadorIdToLocatarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locatario', function (Blueprint $table) {
            $table->unsignedInteger('fiador_id');
            $table->foreign('fiador_id')->references('id')->on('fiador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locatario', function (Blueprint $table) {
            //
        });
    }
}
