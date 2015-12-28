<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElderlyLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elderly_language', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('elderly_id')->unsigned();
            $table->foreign('elderly_id')->references('elderly_id')->on('elderly');
            $table->string('language', 50);
            $table->unique(['elderly_id', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('elderly_language');
    }
}
