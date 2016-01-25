<?php

use Illuminate\Database\Seeder;

use App\Staff;

class StaffTableSeeder extends Seeder
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

        // Insert 10 dummy records
        foreach (range(1, 10) as $index) {
            $gender = $faker->randomElement(['male', 'female']);
            $fullName = explode("|", $faker->unique()->nameWithSalutation($gender)); // Extract full name without salutation ("Full Name|Salutation" to array)
            $fullName = $fullName[0];
            $emailName = strtolower(preg_replace('/\s+/', '', $fullName)); // Remove whitespaces in full name, convert to lowercase
            (strlen($emailName) > 8) ? $emailName = substr($emailName, 0, 8) : null; // Extract only 8 characters from full name
            $email = $emailName . '@centreforseniors.org.sg'; // 8 characters from full name + domain name

            Staff::create([
                'name' => $fullName,
                'email' => $email,
                'password' => 'qwerty1234',
                'is_admin' => $faker->boolean(25), // 25% chance of getting true
            ]);
        }
    }
}
