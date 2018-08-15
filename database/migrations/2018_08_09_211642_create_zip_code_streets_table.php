<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZipCodeStreetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zip_code_streets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('zip_code_id')->unsigned();
            $table->integer('street_id')->unsigned();
            $table->integer('data_source_id')->unsigned();
            $table->timestamps();
            $table->foreign('zip_code_id')->references('id')->on('zip_codes')->onUpdate('cascade');
            $table->foreign('street_id')->references('id')->on('streets')->onUpdate('cascade');
            $table->foreign('data_source_id')->references('id')->on('data_sources')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zip_code_streets');
    }
}
