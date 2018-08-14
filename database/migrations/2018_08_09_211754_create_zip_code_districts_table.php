<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZipCodeDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zip_code_districts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('zip_code_id')->unsigned();
            $table->integer('street_id')->unsigned();
            $table->integer('data_source_id')->unsigned();
            $table->timestamps();
            $table->foreign('zip_code_id')->references('id')->on('zip_codes')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade');
            $table->foreign('data_source_id')->references('id')->on('data_source')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zip_code_districts');
    }
}