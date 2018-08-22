<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubZoneUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_zone_users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('sub_zone_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('sub_zone_id')->references('id')->on('sub_zones')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_zone_users');
    }
}
