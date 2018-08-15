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
            $table->timestamps();
            
            $table->integer('zip_code_id')->unsigned();
            $table->integer('district_id')->unsigned();
            $table->integer('data_source_id')->unsigned();

            $table->foreign('zip_code_id')->references('id')->on('zip_codes')->onUpdate('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade');
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
        Schema::dropIfExists('zip_code_districts');
    }
}
