<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('task_id');
            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('activity_id')->on('activities');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('volunteer_id')->on('volunteers');
            $table->enum('status', ['new task', 'pick-up', 'at check-up', 'check-up completed', 'completed'])->default('new task');
            $table->enum('approval', ['pending', 'withdrawn', 'rejected', 'approved'])->default('pending');
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
        Schema::drop('tasks');
    }
}
