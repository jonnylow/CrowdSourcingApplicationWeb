<?php

use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('activities')->insert([
            'name' => 'Henderson Home to SGH',
            'location_from' => 'Henderson Home',
            'location_from_long' => 103.822,
            'location_from_lat' => 1.28441,
            'location_to' => 'Singapore General Hospital',
            'location_to_long' => 103.835,
            'location_to_lat' => 1.2795,
            'datetime_start' => '2015-11-05 10:00:00',
            'expected_duration_minutes' => 120,
            'more_information' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin molestie, ligula in sagittis egestas, felis orci tempor augue, vitae porttitor magna quam et leo. Nulla faucibus elit et varius pellentes',
            'elderly_name' => 'Chanel',
            'next_of_kin_name' => 'Ugine',
            'next_of_kin_contact' => '87654321',
            'senior_centre_id' => 1,
            'vwo_user_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
