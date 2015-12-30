<?php

use Illuminate\Database\Seeder;

class CentreStaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('centre_staff')->insert([
            'centre_id' => 1,
            'staff_id' => 1,
        ]);

        DB::table('centre_staff')->insert([
            'centre_id' => 1,
            'staff_id' => 2,
        ]);

        DB::table('centre_staff')->insert([
            'centre_id' => 2,
            'staff_id' => 3,
        ]);
    }
}
