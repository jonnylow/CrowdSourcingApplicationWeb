<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('tasks')->insert([
            'activity_id' => 1,
            'volunteer_id' => 1,
        ]);
    }
}
