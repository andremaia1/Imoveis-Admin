<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCondominioIdToPagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagamento', function (Blueprint $table) {
            $table->unsignedInteger('condominio_id')->nullable();
            $table->foreign('condominio_id')->references('id')->on('condominio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagamento', function (Blueprint $table) {
            //
        });
    }
}
