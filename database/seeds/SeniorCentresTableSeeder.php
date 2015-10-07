<?php

use Illuminate\Database\Seeder;

class SeniorCentresTableSeeder extends Seeder
{
    protected $primaryKey = 'senior_centre_id';
    public $timestamps = false;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('senior_centres')->insert([
            'name' => 'Henderson Home',
            'contact_no' => '62704619',
            'address_1' => 'Blk 117 Bukit Merah View',
            'address_2' => '#01-205',
            'postal_code' => '151117',
            'description' => 'Seniors Activity Centre',
        ]);
    }
}
