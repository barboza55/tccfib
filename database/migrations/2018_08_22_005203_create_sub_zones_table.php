<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name',150);
            $table->string('note',200);
            $table->integer('zone_id')->unsigned();

            $table->foreign('zone_id')->references('id')->on('zones')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_zones');
    }
}
