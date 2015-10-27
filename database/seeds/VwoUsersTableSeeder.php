<?php

use Illuminate\Database\Seeder;

class VwoUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('vwo_users')->insert([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('qwerty1234'),
            'senior_centre_id' => 1,
            'is_admin' => false,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('vwo_users')->insert([
            'name' => 'Alice Tan',
            'email' => 'alice@example.com',
            'password' => bcrypt('zxcvbn1234'),
            'senior_centre_id' => 1,
            'is_admin' => false,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('vwo_users')->insert([
            'name' => 'Felicia Teo',
            'email' => 'felicia@example.com',
            'password' => bcrypt('qwerty5678'),
            'senior_centre_id' => 1,
            'is_admin' => false,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
