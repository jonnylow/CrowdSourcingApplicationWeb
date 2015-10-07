<?php

use Illuminate\Database\Seeder;

class VolunteersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('volunteers')->insert([
            'nric' => 'S1234567A',
            'name' => 'Peter Lim',
            'email' => 'peter@example.com',
            'password' => bcrypt('12345678'),
            'gender' => 'M',
            'date_of_birth' => '1990-03-04',
            'contact_no' => '92345678',
            'occupation' => 'Student',
            'has_car' => false,
            'area_of_preference_1' => 'Befriending',
            'area_of_preference_2' => 'Escorting',
            'image_nric_front' => 'image/image_nric_front.jpg',
            'image_nric_back' => 'image/image_nric_back.jpg',
            'is_approved' => true,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
