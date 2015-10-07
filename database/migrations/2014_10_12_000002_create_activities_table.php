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
            $table->string('name', 100);
            $table->string('location_from');
            $table->float('location_from_long');
            $table->float('location_from_lat');
            $table->string('location_to');
            $table->float('location_to_long');
            $table->float('location_to_lat');
            $table->datetime('datetime_start');
            $table->integer('expected_duration_minutes');
            $table->string('more_information');
            $table->string('elderly_name');
            $table->string('next_of_kin_name');
            $table->char('next_of_kin_contact',8);
            $table->integer('senior_centre_id')->unsigned();
            $table->foreign('senior_centre_id')->references('senior_centre_id')->on('senior_centres');
            $table->integer('vwo_user_id')->unsigned();
            $table->foreign('vwo_user_id')->references('vwo_user_id')->on('vwo_users');
            $table->nullableTimestamps();
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
