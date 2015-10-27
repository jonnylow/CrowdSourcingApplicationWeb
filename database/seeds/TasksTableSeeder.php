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
            'activity_id' => 17,
            'volunteer_id' => 36,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 17,
            'volunteer_id' => 37,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 17,
            'volunteer_id' => 38,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 17,
            'volunteer_id' => 39,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 17,
            'volunteer_id' => 41,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 17,
            'volunteer_id' => 42,
            'approval' => 'pending',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 11,
            'volunteer_id' => 36,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 12,
            'volunteer_id' => 37,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 13,
            'volunteer_id' => 38,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 14,
            'volunteer_id' => 39,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 15,
            'volunteer_id' => 41,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        DB::table('tasks')->insert([
            'activity_id' => 16,
            'volunteer_id' => 42,
            'status' => 'completed',
            'approval' => 'approved',
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);
    }
}
