<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('ddd');
            $table->string('phone');
            $table->timeTz('start_time');
            $table->timeTz('end_time');

            $table->integer('type_phone_id')->unsigned();
            $table->integer('entity_id')->unsigned();

            $table->foreign('type_phone_id')->references('id')->on('type_phones')->onUpdate('cascade');
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
        Schema::dropIfExists('phones');
    }
}
