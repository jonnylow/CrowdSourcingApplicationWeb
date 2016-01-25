<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Activity;
use App\Elderly;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create(); // Create a faker, add en_SG providers
        $faker->addProvider(new Faker\Provider\en_SG\Address($faker));
        $faker->addProvider(new Faker\Provider\en_SG\Enhanced($faker));
        $faker->addProvider(new Faker\Provider\en_SG\Person($faker));
        $faker->addProvider(new Faker\Provider\en_SG\PhoneNumber($faker));
        $faker->seed(9876); // Calling the same script twice with the same seed produces the same results

        $durations = [30, 45, 60, 75, 90, 105, 120, 135, 150, 165, 180];

        // Insert 30 dummy records
        foreach (range(1, 30) as $index) {
            $startDate = $faker->dateTimeBetween('-3 months', '3 months');
            $startHour = ['08', '09', '10', '11', '13', '14', '15', '16'];
            $startMin = ['00', '15', '30', '45'];

            while (Carbon::instance($startDate)->dayOfWeek === Carbon::SUNDAY) {
                $startDate = $faker->dateTimeBetween('-3 months', '3 months');
            }

            if($startDate === Carbon::SATURDAY) {
                $startHour = ['08', '09', '10', '11'];
            }

            $startTime = $faker->randomElement($startHour) . ":" . $faker->randomElement($startMin) . ":00";
            $elderly = Elderly::with('centre')->find($faker->numberBetween(1, 15));
            $staffList = $elderly->centre->staff->lists('staff_id')->toArray();

            Activity::create([
                'datetime_start' => $startDate->format('Y-m-d') . " " . $startTime,
                'expected_duration_minutes' => $faker->randomElement($durations),
                'category' => 'transport',
                'more_information' => $faker->optional(0.4, '')->sentence(10, true),  // 60% chance of blank
                'location_from_id' => $elderly->centre_id,
                'location_to_id' => $faker->numberBetween(4, 6),
                'elderly_id' => $elderly->elderly_id,
                'centre_id' => $elderly->centre_id,
                'staff_id' => $faker->randomElement($staffList),
            ]);
        }
    }
}
