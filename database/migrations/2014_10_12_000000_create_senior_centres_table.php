<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeniorCentresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senior_centres', function (Blueprint $table) {
            $table->increments('senior_centre_id');
            $table->string('name', 100);
            $table->char('contact_no', 8);
            $table->string('address_1', 50);
            $table->string('address_2', 50)->nullable();
            $table->char('postal_code', 6);
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('senior_centres');
    }
}
