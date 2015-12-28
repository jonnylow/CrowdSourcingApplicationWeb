<?php

use Illuminate\Database\Seeder;

class RanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('ranks')->insert([
            'name' => 'Bronze',
            'points_required' => 0,
        ]);

        DB::table('ranks')->insert([
            'name' => 'Silver',
            'points_required' => 50,
        ]);

        DB::table('ranks')->insert([
            'name' => 'Gold',
            'points_required' => 100,
        ]);

        DB::table('ranks')->insert([
            'name' => 'Platinum',
            'points_required' => 150,
        ]);
    }
}
