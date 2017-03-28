<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaAreaCurriculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_curriculo', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('area_id')->unsigned();
            $table->integer('curriculo_id')->unsigned();

            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('curriculo_id')->references('id')->on('curriculos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_curriculo');
    }
}
