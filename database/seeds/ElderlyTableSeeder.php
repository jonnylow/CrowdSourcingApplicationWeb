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
            'elderly_id' => 1,
            'nric' => 'S1234567Z',
            'name' => 'Tan Ah Kow',
            'gender' => 'M',
            'next_of_kin_name' => 'Tan Ah Mao',
            'next_of_kin_contact' => 98765432,
            'medical_condition' => '',
            'image_photo' => 'image.jpeg',
            'senior_centre_id' => 1,
        ]);
    }
}
