<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentreStaffPivotTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centre_staff', function(Blueprint $table)
        {
            $table->integer('centre_id')->unsigned();
            $table->foreign('centre_id')->references('centre_id')->on('centres')->onDelete('cascade');
            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('staff_id')->on('staff')->onDelete('cascade');
            $table->primary(['centre_id', 'staff_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('centre_staff');
    }

}