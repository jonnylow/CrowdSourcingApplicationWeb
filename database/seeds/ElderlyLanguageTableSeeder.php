<?php

use Illuminate\Database\Seeder;

use App\ElderlyLanguage;

class ElderlyLanguageTableSeeder extends Seeder
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

        $languages = array('Cantonese', 'English', 'Hainanese', 'Hakka',
            'Hokkien', 'Malay', 'Mandarin', 'Tamil', 'Teochew');

        // Insert dummy records for 15 dummy elderly account
        foreach (range(1, 15) as $index) {
            $languages = $faker->shuffle($languages);
            $numOfLanguages = $faker->numberBetween(1, 4);
            $chosenLanguages = $faker->randomElements($languages, $numOfLanguages);

            foreach ($chosenLanguages as $language) {
                ElderlyLanguage::create([
                    'elderly_id' => $index,
                    'language' => $language,
                ]);
            }
        }
    }
}
