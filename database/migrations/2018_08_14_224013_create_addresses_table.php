<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();            
            $table->string('number');
            $table->string('adjunct');
            
            $table->integer('district_id')->unsigned();
            $table->integer('zip_code_id')->unsigned();
            $table->integer('type_address_id')->unsigned();
            $table->integer('entity_id')->unsigned();

            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade');
            $table->foreign('zip_code_id')->references('id')->on('zip_codes')->onUpdate('cascade');
            $table->foreign('type_address_id')->references('id')->on('type_addresses')->onUpdate('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
