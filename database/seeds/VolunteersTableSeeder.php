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
            'volunteer_id' => 36,
            'nric' => 'S8767897R',
            'name' => 'Kenneth Han',
            'email' => 'kenneth@gmail.com',
            'password' => md5('qwerty123'),
            'gender' => 'M',
            'date_of_birth' => '1987-04-13',
            'contact_no' => '95678956',
            'occupation' => 'Accountant',
            'has_car' => true,
            'area_of_preference_1' => 'Befriend senior citizens',
            'area_of_preference_2' => 'Lead games/exercises',
            'image_nric_front' => 'image/image_nric_front.jpg',
            'image_nric_back' => 'image/image_nric_back.jpg',
            'is_approved' => true,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('volunteers')->insert([
            'volunteer_id' => 37,
            'nric' => 'S9008647D',
            'name' => 'Andrew Tan',
            'email' => 'andrew@gmail.com',
            'password' => md5('qwerty123'),
            'gender' => 'M',
            'date_of_birth' => '1990-06-25',
            'contact_no' => '92045757',
            'occupation' => 'Teacher',
            'has_car' => true,
            'area_of_preference_1' => 'Written translation for brochures',
            'area_of_preference_2' => 'Prepare tea/snacks',
            'image_nric_front' => 'image/image_nric_front.jpg',
            'image_nric_back' => 'image/image_nric_back.jpg',
            'is_approved' => true,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('volunteers')->insert([
            'volunteer_id' => 38,
            'nric' => 'S7756758G',
            'name' => 'Sarah Ng',
            'email' => 'sarah@gmail.com',
            'password' => md5('qwerty123'),
            'gender' => 'F',
            'date_of_birth' => '1977-11-05',
            'contact_no' => '96495648',
            'occupation' => 'IT Consultant',
            'has_car' => true,
            'area_of_preference_1' => 'Design/Maintain Webpage',
            'area_of_preference_2' => 'Written translation for brochures',
            'image_nric_front' => 'image/image_nric_front.jpg',
            'image_nric_back' => 'image/image_nric_back.jpg',
            'is_approved' => true,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('volunteers')->insert([
            'volunteer_id' => 39,
            'nric' => 'S9553965F',
            'name' => 'Hansel Wong',
            'email' => 'hansel@gmail.com',
            'password' => md5('qwerty123'),
            'gender' => 'F',
            'date_of_birth' => '1995-04-02',
            'contact_no' => '84648353',
            'occupation' => 'Student',
            'has_car' => false,
            'area_of_preference_1' => 'Lead games/exercises',
            'area_of_preference_2' => 'Organize/participate in fund raising actvities',
            'image_nric_front' => 'image/image_nric_front.jpg',
            'image_nric_back' => 'image/image_nric_back.jpg',
            'is_approved' => true,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('volunteers')->insert([
            'volunteer_id' => 41,
            'nric' => 'S5467897R',
            'name' => 'Sam Gan',
            'email' => 'sam@gmail.com',
            'password' => md5('qwerty123'),
            'gender' => 'M',
            'date_of_birth' => '1954-05-20',
            'contact_no' => '94567847',
            'occupation' => 'Retiree',
            'has_car' => true,
            'area_of_preference_1' => 'Befriend senior citizens',
            'area_of_preference_2' => 'Prepare tea/snacks',
            'image_nric_front' => 'image/image_nric_front.jpg',
            'image_nric_back' => 'image/image_nric_back.jpg',
            'is_approved' => true,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('volunteers')->insert([
            'volunteer_id' => 42,
            'nric' => 'S9208647D',
            'name' => 'Elias Leo',
            'email' => 'elias@gmail.com',
            'password' => md5('qwerty123'),
            'gender' => 'F',
            'date_of_birth' => '1992-06-05',
            'contact_no' => '92345674',
            'occupation' => 'Student',
            'has_car' => false,
            'area_of_preference_1' => 'Written translation for brochures',
            'area_of_preference_2' => 'Prepare tea/snacks',
            'image_nric_front' => 'image/image_nric_front.jpg',
            'image_nric_back' => 'image/image_nric_back.jpg',
            'is_approved' => true,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('volunteers')->insert([
            'volunteer_id' => 43,
            'nric' => 'S7756758G',
            'name' => 'Lionel Wong',
            'email' => 'lionel@gmail.com',
            'password' => md5('qwerty123'),
            'gender' => 'M',
            'date_of_birth' => '1977-10-15',
            'contact_no' => '90875678',
            'occupation' => 'Sales Person',
            'has_car' => true,
            'area_of_preference_1' => 'Organize/participate in fund raising activities',
            'area_of_preference_2' => 'Written translation for brochures',
            'image_nric_front' => 'image/image_nric_front.jpg',
            'image_nric_back' => 'image/image_nric_back.jpg',
            'is_approved' => false,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('volunteers')->insert([
            'volunteer_id' => 44,
            'nric' => 'S9353965F',
            'name' => 'Candice Ng',
            'email' => 'candice@gmail.com',
            'password' => md5('qwerty123'),
            'gender' => 'F',
            'date_of_birth' => '1993-04-17',
            'contact_no' => '83456763',
            'occupation' => 'Student',
            'has_car' => true,
            'area_of_preference_1' => 'Design/Maintain Webpage',
            'area_of_preference_2' => 'Organize/participate in fund raising activities',
            'image_nric_front' => 'image/image_nric_front.jpg',
            'image_nric_back' => 'image/image_nric_back.jpg',
            'is_approved' => true,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
