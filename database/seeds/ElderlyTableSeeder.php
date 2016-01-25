<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Elderly;

class ElderlyTableSeeder extends Seeder
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

        $conditions = array('Osteoporosis', 'Dementia', 'Pneumonia', 'Gastrointestinal Infections',
            'Urinary Tract Infections', 'Hypertension', 'High Blood Pressure');

        // Insert 15 dummy records
        foreach (range(1, 15) as $index) {
            $gender = $faker->randomElement(['male', 'female']);
            $birthYear = $faker->dateTimeBetween('-85 years', '-60 years')->format('Y');
            $fullName = explode("|", $faker->unique()->nameWithSalutation($gender)); // Extract full name without salutation ("Full Name|Salutation" to array)
            $fullName = $fullName[0];
            $NOKfullName = explode("|", $faker->unique()->nameWithSalutation($gender)); // Extract full name without salutation ("Full Name|Salutation" to array)
            $NOKfullName = $NOKfullName[0];
            $centre = $faker->numberBetween(1, 3);

            Elderly::create([
                'nric' => $faker->unique()->nric,
                'name' => $fullName,
                'gender' => ucwords($gender[0]),
                'birth_year' => $birthYear,
                'next_of_kin_name' => $NOKfullName,
                'next_of_kin_contact' => preg_replace('/-/', '', $faker->mobile),
                'medical_condition' => $faker->optional(0.4, '')->randomElement($conditions), // 60% chance of blank
                'image_photo' => 'image.jpeg',
                'centre_id' => $centre,
            ]);
        }
    }
}
