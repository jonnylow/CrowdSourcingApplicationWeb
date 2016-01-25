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
            $table->char('nric', 9)/*->unique()*/;
            $table->string('name', 100);
            $table->string('email')/*->unique()*/;
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
            $table->enum('is_approved', ['pending', 'rejected', 'approved'])->default('pending');
            $table->integer('rank_id')->unsigned();
            $table->foreign('rank_id')->references('rank_id')->on('ranks');
            $table->timestamps();
        });

        // A quick hack to solve the case sensitive unique for nric & email columns
        // Source: http://shuber.io/case-insensitive-unique-constraints-in-postgres
        DB::statement('CREATE UNIQUE INDEX volunteers_nric_unique on volunteers (LOWER(nric));');
        DB::statement('CREATE UNIQUE INDEX volunteers_email_unique on volunteers (LOWER(email));');
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
