<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('corporate_name');// razao social
            $table->string('trade_name');// nome fantasia
            $table->string('cnpj');

            $table->integer('user_id')->unsigned();//principal responsavel
            $table->integer('type_organization_id')->unsigned();
            $table->integer('organization_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('type_organization_id')->references('id')->on('type_organizations')->onUpdate('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
