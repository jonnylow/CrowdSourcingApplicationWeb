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
            'volunteer_id' => 5,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 1,
            'volunteer_id' => 1,
            'approval' => 'rejected',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 2,
            'volunteer_id' => 2,
            'approval' => 'rejected',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 2,
            'volunteer_id' => 3,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 3,
            'volunteer_id' => 2,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 4,
            'volunteer_id' => 1,
            'status' => 'pick-up',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 4,
            'volunteer_id' => 5,
            'approval' => 'rejected',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 4,
            'volunteer_id' => 6,
            'approval' => 'rejected',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 4,
            'volunteer_id' => 8,
            'approval' => 'rejected',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 5,
            'volunteer_id' => 1,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 5,
            'volunteer_id' => 4,
            'approval' => 'withdrawn',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 5,
            'volunteer_id' => 6,
            'approval' => 'rejected',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 6,
            'volunteer_id' => 1,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 7,
            'volunteer_id' => 5,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 7,
            'volunteer_id' => 6,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 8,
            'volunteer_id' => 5,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
