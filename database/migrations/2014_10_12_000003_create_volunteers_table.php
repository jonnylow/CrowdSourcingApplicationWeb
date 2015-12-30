<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->increments('volunteer_id');
            $table->char('nric', 9)->unique();
            $table->string('name', 100);
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->enum('gender', ['M', 'F']);
            $table->date('date_of_birth');
            $table->char('contact_no', 8);
            $table->string('occupation');
            $table->boolean('has_car');
            $table->integer('minutes_volunteered')->default(0);
            $table->string('area_of_preference_1');
            $table->string('area_of_preference_2');
            $table->string('image_nric_front')->nullable();
            $table->string('image_nric_back')->nullable();
            $table->boolean('is_approved')->default(false);
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
        Schema::drop('volunteers');
    }
}
