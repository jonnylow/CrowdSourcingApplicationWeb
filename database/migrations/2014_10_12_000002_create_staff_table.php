<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration that creates the staff table in the database.
 */
class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('staff_id');
            $table->string('name', 50);
            $table->string('email')/*->unique()*/;
            $table->string('password', 60);
            $table->boolean('is_admin');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // A quick hack to solve the case sensitive unique for email column
        // Source: http://shuber.io/case-insensitive-unique-constraints-in-postgres
        DB::statement('CREATE UNIQUE INDEX staff_email_unique on staff (LOWER(email));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('staff');
    }
}
