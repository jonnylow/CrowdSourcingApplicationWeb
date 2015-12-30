<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeniorCentreStaffPivotTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senior_centre_staff', function(Blueprint $table)
        {
            $table->integer('senior_centre_id')->unsigned();
            $table->foreign('senior_centre_id')->references('senior_centre_id')->on('senior_centres')->onDelete('cascade');
            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('staff_id')->on('staff')->onDelete('cascade');
            $table->primary(array('senior_centre_id', 'staff_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('senior_centre_staff');
    }

}