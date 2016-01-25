<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Volunteer;

class VolunteersTableSeeder extends Seeder
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

        $jobTitles = array('Accountant', 'Artist', 'Artiste', 'Associate Treasury Markets', 'Bank Executive',
            'Banker', 'Bus Captain', 'Cashier', 'Chemist', 'Civil Servant', 'Civil Service', 'Cleaner',
            'Company Director', 'Compliance Officer', 'Credit Control VP', 'Customer Service', 'Designer',
            'Director', 'Doctor', 'Driver', 'Education Officer', 'Electrician', 'Engineer', 'Entrepreneur',
            'Events Industry', 'Executive', 'Finance Consultant', 'Financial Service Consultant', 'Freelancer',
            'Hawker', 'Homemaker', 'Hairdresser', 'HR Manager', 'Human Resource Executive', 'Insurance Agent',
            'Jobless', 'Junior Executive', 'Manager', 'Music director', 'Nurse', 'Optometrist', 'Penetration Tester',
            'Pilot', 'Police', 'Project Engineer', 'Project Manager', 'Self-employed', 'Soldier', 'Surgeon',
            'Taxi Driver', 'Teacher', 'Tuition Teacher', 'Unemployed');

        // Insert 10 dummy records
        foreach (range(1, 10) as $index) {
            $gender = $faker->randomElement(['male', 'female']);
            $dob = $faker->dateTimeBetween('-50 years', '-16 years');
            $fullName = explode("|", $faker->unique()->nameWithSalutation($gender)); // Extract full name without salutation ("Full Name|Salutation" to array)
            $fullName = $fullName[0];
            $emailName = strtolower(preg_replace('/\s+/', '', $fullName)); // Remove whitespaces in full name, convert to lowercase
            (strlen($emailName) > 8) ? $emailName = substr($emailName, 0, 8) : null; // Extract only 8 characters from full name
            $email = $emailName . substr($dob->format('Y'), -2) . '@' . $faker->localFreeEmailDomain; // 8 characters from full name + last 2 digit from birth year + email domain
            $approval = $faker->optional(0.9, 'rejected')->randomElement(['pending', 'approved']); // 10% chance of rejected

            ($dob->diff(Carbon::now())->y > 21) // If age is greater than 21
                ? $job = $faker->optional(0.9, 'Student')->randomElement($jobTitles) // 10% chance of Student
                : $job = 'Student'; // Age 21 or younger are all students

            Volunteer::create([
                'nric' => $faker->unique()->nric,
                'name' => $fullName,
                'email' => $email,
                'password' => 'qwerty123',
                'gender' => ucwords($gender[0]),
                'date_of_birth' => $dob,
                'contact_no' => preg_replace('/-/', '', $faker->mobile),
                'occupation' => $job,
                'has_car' => $faker->boolean(30), // 30% chance of getting true
                'minutes_volunteered' => $approval == 'rejected' ? 0 : $faker->optional(0.6, 0)->numberBetween(1, 9) * (60 * $faker->numberBetween(1, 3)), // 0 minute if rejected, else 40% chance of 0
                'area_of_preference_1' => 'Befriend senior citizens',
                'area_of_preference_2' => 'Lead games/exercises',
                'image_nric_front' => 'image/image_nric_front.jpg',
                'image_nric_back' => 'image/image_nric_back.jpg',
                'is_approved' => $approval,
                'rank_id' => 4,
            ]);
        }
    }
}
