<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('email');

            $table->integer('type_email_id')->unsigned();
            $table->integer('entity_id')->unsigned();

            $table->foreign('type_email_id')->references('id')->on('type_emails')->onUpdate('cascade');
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
        Schema::dropIfExists('emails');
    }
}
