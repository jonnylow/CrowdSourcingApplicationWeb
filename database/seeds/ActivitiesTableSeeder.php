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
            'name' => 'Henderson Home - Singapore General Hospital',
            'location_from' => '117 Bukit Merah View, 151117, Singapore',
            'location_from_long' => 103.82190657700056,
            'location_from_lat' => 1.2843010410004467,
            'location_to' => '1 Hospital Drive, 169608, Singapore',
            'location_to_long' => 103.83549970200056,
            'location_to_lat' => 1.2798006200004579,
            'datetime_start' => '2015-10-20 10:00:00',
            'expected_duration_minutes' => 30,
            'more_information' => '',
            'elderly_name' => 'Chanel Chua',
            'next_of_kin_name' => 'Ugine Chua',
            'next_of_kin_contact' => '91234123',
            'senior_centre_id' => 1,
            'vwo_user_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'name' => 'Henderson Home - Bukit Merah Polyclinic',
            'location_from' => '117 Bukit Merah View, 151117, Singapore',
            'location_from_long' => 103.82190657700056,
            'location_from_lat' => 1.2843010410004467,
            'location_to' => '163 Bukit Merah Central, 150163, Singapore',
            'location_to_long' => 103.81696511400054,
            'location_to_lat' => 1.2837871400004133,
            'datetime_start' => '2015-10-23 12:00:00',
            'expected_duration_minutes' => 60,
            'more_information' => '',
            'elderly_name' => 'Lim Yoke En',
            'next_of_kin_name' => 'Janelle Lim',
            'next_of_kin_contact' => '95432678',
            'senior_centre_id' => 1,
            'vwo_user_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'name' => 'Henderson Home - Singapore General Hospital',
            'location_from' => '117 Bukit Merah View, 151117, Singapore',
            'location_from_long' => 103.82190657700056,
            'location_from_lat' => 1.2843010410004467,
            'location_to' => '1 Hospital Drive, 169608, Singapore',
            'location_to_long' => 103.83549970200056,
            'location_to_lat' => 1.2798006200004579,
            'datetime_start' => '2015-10-30 09:00:00',
            'expected_duration_minutes' => 45,
            'more_information' => 'Rejection reason: A volunteer signed up earlier for this activity',
            'elderly_name' => 'Gan Teck Ghee',
            'next_of_kin_name' => 'Lim Chun Pin',
            'next_of_kin_contact' => '95674308',
            'senior_centre_id' => 1,
            'vwo_user_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'name' => 'Henderson Home - Singapore General Hospital',
            'location_from' => '117 Bukit Merah View, 151117, Singapore',
            'location_from_long' => 103.82190657700056,
            'location_from_lat' => 1.2843010410004467,
            'location_to' => '1 Hospital Drive, 169608, Singapore',
            'location_to_long' => 103.83549970200056,
            'location_to_lat' => 1.2798006200004579,
            'datetime_start' => '2015-11-02 13:00:00',
            'expected_duration_minutes' => 30,
            'more_information' => '',
            'elderly_name' => 'Felicia Han',
            'next_of_kin_name' => 'Han Kenny',
            'next_of_kin_contact' => '81345275',
            'senior_centre_id' => 1,
            'vwo_user_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'name' => 'Henderson Home - Singapore General Hospital',
            'location_from' => '117 Bukit Merah View, 151117, Singapore',
            'location_from_long' => 103.82190657700056,
            'location_from_lat' => 1.2843010410004467,
            'location_to' => '1 Hospital Drive, 169608, Singapore',
            'location_to_long' => 103.83549970200056,
            'location_to_lat' => 1.2798006200004579,
            'datetime_start' => '2015-11-05 11:30:00',
            'expected_duration_minutes' => 60,
            'more_information' => '',
            'elderly_name' => 'Lim Seng Hwee',
            'next_of_kin_name' => 'Alicia Lim',
            'next_of_kin_contact' => '94567567',
            'senior_centre_id' => 1,
            'vwo_user_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'name' => 'Henderson Home - Singapore General Hospital',
            'location_from' => '117 Bukit Merah View, 151117, Singapore',
            'location_from_long' => 103.82190657700056,
            'location_from_lat' => 1.2843010410004467,
            'location_to' => '1 Hospital Drive, 169608, Singapore',
            'location_to_long' => 103.83549970200056,
            'location_to_lat' => 1.2798006200004579,
            'datetime_start' => '2015-11-08 09:00:00',
            'expected_duration_minutes' => 90,
            'more_information' => '',
            'elderly_name' => 'Chanel Chua',
            'next_of_kin_name' => 'Ugine Chua',
            'next_of_kin_contact' => '81234345',
            'senior_centre_id' => 1,
            'vwo_user_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'name' => 'Henderson Home - Bukit Merah Polyclinic',
            'location_from' => '117 Bukit Merah View, 151117, Singapore',
            'location_from_long' => 103.82190657700056,
            'location_from_lat' => 1.2843010410004467,
            'location_to' => '163 Bukit Merah Central, 150163, Singapore',
            'location_to_long' => 103.81696511400054,
            'location_to_lat' => 1.2837871400004133,
            'datetime_start' => '2015-11-25 10:00:00',
            'expected_duration_minutes' => 30,
            'more_information' => '',
            'elderly_name' => 'Foo Heng Gwan',
            'next_of_kin_name' => 'Lim Swee Feng',
            'next_of_kin_contact' => '90987654',
            'senior_centre_id' => 1,
            'vwo_user_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'name' => 'Henderson Home - Singapore General Hospital',
            'location_from' => '117 Bukit Merah View, 151117, Singapore',
            'location_from_long' => 103.82190657700056,
            'location_from_lat' => 1.2843010410004467,
            'location_to' => '1 Hospital Drive, 169608, Singapore',
            'location_to_long' => 103.83549970200056,
            'location_to_lat' => 1.2798006200004579,
            'datetime_start' => '2015-11-20 11:30:00',
            'expected_duration_minutes' => 60,
            'more_information' => '',
            'elderly_name' => 'Lam Yao Long',
            'next_of_kin_name' => 'Alvin Lam',
            'next_of_kin_contact' => '95674675',
            'senior_centre_id' => 1,
            'vwo_user_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
