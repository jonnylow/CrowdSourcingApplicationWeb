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
            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('activity_id')->on('activities');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('volunteer_id')->on('volunteers');
            $table->timestamp('registered_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('status')->default('New Task');
            $table->enum('approval', ['pending', 'withdrawn', 'rejected', 'approved'])->default('pending');
            $table->primary(['activity_id', 'volunteer_id', 'registered_at']);
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
