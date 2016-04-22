<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration that creates the tasks table in the database.
 */
class CreateTasksPivotTable extends Migration
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
            $table->integer('volunteer_id')->unsigned()->index();
            $table->foreign('volunteer_id')->references('volunteer_id')->on('volunteers');
            $table->integer('activity_id')->unsigned()->index();
            $table->foreign('activity_id')->references('activity_id')->on('activities');
            $table->enum('status', ['new task', 'pick-up', 'at check-up', 'check-up completed', 'completed'])->default('new task');
            $table->enum('approval', ['pending', 'withdrawn', 'rejected', 'approved'])->default('pending');
            $table->string('comment')->nullable();
            $table->timestamps();
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
        Schema::drop('tasks');
    }
}
