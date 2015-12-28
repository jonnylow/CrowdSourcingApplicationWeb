<?php

use Illuminate\Database\Seeder;

class SeniorCentresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('senior_centres')->insert([
            'senior_centre_id' => 1,
            'name' => 'Henderson Home',
            'contact_no' => '62704619',
            'address_1' => '117 Bukit Merah View',
            'address_2' => '#01-201',
            'postal_code' => '151117',
            'description' => 'Silver Circle',
        ]);

        DB::table('senior_centres')->insert([
            'senior_centre_id' => 2,
            'name' => 'Dakota Crescent',
            'contact_no' => '67156762',
            'address_1' => '62 Dakota Crescent',
            'address_2' => '#01-315',
            'postal_code' => '390062',
            'description' => 'Silver Circle',
        ]);
    }
}
