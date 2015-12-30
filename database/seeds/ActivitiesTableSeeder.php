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
            'activity_id' => 11,
            'datetime_start' => '2016-10-20 10:00:00',
            'expected_duration_minutes' => 30,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 12,
            'datetime_start' => '2016-10-23 12:00:00',
            'expected_duration_minutes' => 60,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 5,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 13,
            'datetime_start' => '2016-10-26 13:00:00',
            'expected_duration_minutes' => 45,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 14,
            'datetime_start' => '2016-10-20 13:00:00',
            'expected_duration_minutes' => 30,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 15,
            'datetime_start' => '2016-10-23 12:00:00',
            'expected_duration_minutes' => 60,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 5,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 16,
            'datetime_start' => '2016-10-26 09:00:00',
            'expected_duration_minutes' => 45,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 17,
            'datetime_start' => '2016-11-05 11:30:00',
            'expected_duration_minutes' => 60,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 18,
            'datetime_start' => '2016-11-02 13:00:00',
            'expected_duration_minutes' => 30,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 19,
            'datetime_start' => '2016-10-30 13:00:00',
            'expected_duration_minutes' => 60,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 20,
            'datetime_start' => '2016-10-30 10:00:00',
            'expected_duration_minutes' => 45,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 5,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 21,
            'datetime_start' => '2016-10-29 11:30:00',
            'expected_duration_minutes' => 30,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 22,
            'datetime_start' => '2016-10-29 09:00:00',
            'expected_duration_minutes' => 90,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 23,
            'datetime_start' => '2016-10-28 10:00:00',
            'expected_duration_minutes' => 30,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 5,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('activities')->insert([
            'activity_id' => 24,
            'datetime_start' => '2016-10-28 11:30:00',
            'expected_duration_minutes' => 60,
            'category' => 'transport',
            'more_information' => '',
            'location_from_id' => 1,
            'location_to_id' => 4,
            'elderly_id' => 1,
            'centre_id' => 1,
            'staff_id' => 1,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
