<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('activity_id');
            $table->datetime('datetime_start');
            $table->integer('expected_duration_minutes')->unsigned();
            $table->enum('category', ['transport']);
            $table->string('more_information')->nullable();
            $table->integer('location_from_id')->unsigned();
            $table->foreign('location_from_id')->references('centre_id')->on('centres');
            $table->integer('location_to_id')->unsigned();
            $table->foreign('location_to_id')->references('centre_id')->on('centres');
            $table->integer('elderly_id')->unsigned();
            $table->foreign('elderly_id')->references('elderly_id')->on('elderly');
            $table->integer('centre_id')->unsigned();
            $table->foreign('centre_id')->references('centre_id')->on('centres');
            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('staff_id')->on('staff');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activities');
    }
}
