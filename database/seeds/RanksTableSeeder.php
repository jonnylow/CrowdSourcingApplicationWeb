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
            'rank' => 1,
            'name' => 'Platinum',
            'min' => 150,
            'max' => 65535,
        ]);

        DB::table('ranks')->insert([
            'rank' => 2,
            'name' => 'Gold',
            'min' => 100,
            'max' => 149,
        ]);

        DB::table('ranks')->insert([
            'rank' => 3,
            'name' => 'Silver',
            'min' => 50,
            'max' => 99,
        ]);

        DB::table('ranks')->insert([
            'rank' => 4,
            'name' => 'Bronze',
            'min' => 0,
            'max' => 49,
        ]);
    }
}
