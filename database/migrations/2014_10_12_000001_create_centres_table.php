<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centres', function (Blueprint $table) {
            $table->increments('centre_id');
            $table->string('name', 100);
            $table->string('address')/*->unique()*/;
            $table->char('postal_code', 6);
            $table->float('lng');
            $table->float('lat');
        });

        // A quick hack to solve the case sensitive unique for address column
        // Source: http://shuber.io/case-insensitive-unique-constraints-in-postgres
        DB::statement('CREATE UNIQUE INDEX centres_address_unique on staff (LOWER(address));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('centres');
    }
}
