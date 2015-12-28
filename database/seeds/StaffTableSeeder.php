<?php

use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('staff')->insert([
            'staff_id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('qwerty1234'),
            'is_admin' => false,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('staff')->insert([
            'staff_id' => 2,
            'name' => 'Alice Tan',
            'email' => 'alice@example.com',
            'password' => bcrypt('qwerty1234'),
            'is_admin' => false,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('staff')->insert([
            'staff_id' => 3,
            'name' => 'Felicia Teo',
            'email' => 'felicia@example.com',
            'password' => bcrypt('qwerty1234'),
            'is_admin' => false,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
