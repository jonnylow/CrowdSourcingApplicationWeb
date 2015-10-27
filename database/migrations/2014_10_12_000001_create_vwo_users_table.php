<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVwoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vwo_users', function (Blueprint $table) {
            $table->increments('vwo_user_id');
            $table->string('name', 50);
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->integer('senior_centre_id')->unsigned();
            $table->foreign('senior_centre_id')->references('senior_centre_id')->on('senior_centres');
            $table->boolean('is_admin');
            $table->rememberToken();
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
        Schema::drop('vwo_users');
    }
}
