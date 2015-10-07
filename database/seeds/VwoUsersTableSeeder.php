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
            'password' => bcrypt('qwertyui'),
            'senior_centre_id' => 1,
            'is_admin' => true,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
