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
            $table->string('location_from');
            $table->string('location_from_address');
            $table->float('location_from_long');
            $table->float('location_from_lat');
            $table->string('location_to');
            $table->string('location_to_address');
            $table->float('location_to_long');
            $table->float('location_to_lat');
            $table->datetime('datetime_start');
            $table->integer('expected_duration_minutes')->unsigned();
            $table->string('more_information')->nullable();
            $table->enum('category', ['transport']);
            $table->integer('elderly_id')->unsigned();
            $table->foreign('elderly_id')->references('elderly_id')->on('elderly');
            $table->integer('senior_centre_id')->unsigned();
            $table->foreign('senior_centre_id')->references('senior_centre_id')->on('senior_centres');
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
