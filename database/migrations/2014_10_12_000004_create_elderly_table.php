<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElderlyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elderly', function (Blueprint $table) {
            $table->increments('elderly_id');
            $table->char('nric', 9)/*->unique()*/;
            $table->string('name', 100);
            $table->enum('gender', ['M', 'F']);
            $table->smallInteger('birth_year');
            $table->string('next_of_kin_name', 100);
            $table->char('next_of_kin_contact', 8);
            $table->string('medical_condition')->nullable();
            $table->string('image_photo')->nullable();
            $table->integer('centre_id')->unsigned();
            $table->foreign('centre_id')->references('centre_id')->on('centres');
            $table->timestamps();
        });

        // A quick hack to solve the case sensitive unique for nric column
        // Source: http://shuber.io/case-insensitive-unique-constraints-in-postgres
        DB::statement('CREATE UNIQUE INDEX elderly_nric_unique on elderly (LOWER(nric));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('elderly');
    }
}
