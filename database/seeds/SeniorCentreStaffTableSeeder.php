<?php

use Illuminate\Database\Seeder;

class SeniorCentreStaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('senior_centre_staff')->insert([
            'senior_centre_id' => 1,
            'staff_id' => 1,
        ]);

        DB::table('senior_centre_staff')->insert([
            'senior_centre_id' => 1,
            'staff_id' => 2,
        ]);

        DB::table('senior_centre_staff')->insert([
            'senior_centre_id' => 2,
            'staff_id' => 3,
        ]);
    }
}
