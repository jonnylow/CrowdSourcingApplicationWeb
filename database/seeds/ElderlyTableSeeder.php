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
        $faker = Faker\Factory::create(); // Create a faker, add en_SG providers
        $faker->addProvider(new Faker\Provider\en_SG\Address($faker));
        $faker->addProvider(new Faker\Provider\en_SG\Enhanced($faker));
        $faker->addProvider(new Faker\Provider\en_SG\Person($faker));
        $faker->addProvider(new Faker\Provider\en_SG\PhoneNumber($faker));
        $faker->seed(9876); // Calling the same script twice with the same seed produces the same results

        foreach (range(1,10) as $index) {
            $gender = $faker->randomElement(['male', 'female']);
            $dob = $faker->dateTimeBetween('-50 years', '-16 years');
            $fullName = explode("|", $faker->unique()->nameWithSalutation($gender)); // Extract full name without salutation ("Full Name|Salutation" to array)
            $fullName = $fullName[0];
            $NOKfullName = explode("|", $faker->unique()->nameWithSalutation($gender)); // Extract full name without salutation ("Full Name|Salutation" to array)
            $NOKfullName = $NOKfullName[0];
            $centre = $faker->randomElement(['1','2','3','4','5']);
            $condition = $faker->randomElement(['Osteoporosis','Dementia','Pneumonia','Gastrointestinal Infections','Urinary Tract Infections','Hypertension','High Blood Pressure',' ',' ',' ',' ',' ',' ',' ',' ']);

                Elderly::create([
                'nric' => $faker->unique()->nric,
                'name' => $fullName,
                'gender' => ucwords($gender[0]),
                'next_of_kin_name' => $NOKfullName,
                'next_of_kin_contact' => preg_replace('/-/', '', $faker->mobile),
                'medical_condition' => $condition,
                'image_photo' => 'image.jpeg',
                'centre_id' => $centre,
            ]);
        }

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
