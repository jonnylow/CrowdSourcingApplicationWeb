<?php

use Illuminate\Database\Seeder;

class CentreStaffTableSeeder extends Seeder
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

        // Insert dummy records for 10 dummy staff account (among 3 centres - ID 1, 2, 3)
        foreach (range(1, 10) as $index) {
            $centres = $faker->shuffle([1, 2, 3]);
            $numOfCentres = $faker->numberBetween(1, 3);
            $chosenCentres = $faker->randomElements($centres, $numOfCentres);

            foreach ($chosenCentres as $centre) {
                DB::table('centre_staff')->insert([
                    'centre_id' => $centre,
                    'staff_id' => $index,
                ]);
            }
        }
    }
}
