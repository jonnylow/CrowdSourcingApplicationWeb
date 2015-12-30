<?php

use Illuminate\Database\Seeder;

class ElderlyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('elderly')->insert([
            'nric' => 'S1234567Z',
            'name' => 'Tan Ah Kow',
            'gender' => 'M',
            'next_of_kin_name' => 'Tan Ah Mao',
            'next_of_kin_contact' => '98765432',
            'medical_condition' => '',
            'image_photo' => 'image.jpeg',
            'centre_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('elderly')->insert([
            'nric' => 'S7654321Z',
            'name' => 'Monica Cheng',
            'gender' => 'F',
            'next_of_kin_name' => 'Tan Nelson',
            'next_of_kin_contact' => '87654321',
            'medical_condition' => '',
            'image_photo' => 'image.jpeg',
            'centre_id' => 2,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
