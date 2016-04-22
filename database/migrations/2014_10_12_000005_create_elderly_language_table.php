<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration that creates the elderly_language table in the database.
 */
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
            $table->foreign('elderly_id')->references('elderly_id')->on('elderly')->onDelete('cascade');
            $table->string('language', 50);
            $table->unique(['elderly_id', 'language']);
            $table->softDeletes();
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
