<?php

use Illuminate\Database\Seeder;

use App\Task;

class TasksTableSeeder extends Seeder
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

        // Insert dummy records for 30 dummy activities (among 10 volunteers)
        foreach (range(1, 30) as $index) {
            $numOfApplications = $faker->numberBetween(0, 10);

            if($numOfApplications > 0) {
                foreach (range(1, $numOfApplications) as $index2) {
                    Task::create([
                        'activity_id' => $index,
                        'volunteer_id' => $faker->numberBetween(1, 10),
                        'approval' => $faker->optional(0.9, 'withdrawn')->randomElement(['pending', 'rejected', 'approved']), // 10% chance of withdrawn
                    ]);
                }
            }
        }
    }
}
