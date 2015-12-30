<?php

use Illuminate\Database\Seeder;

class ElderlyLanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('elderly_language')->insert([
            'elderly_id' => 1,
            'language' => 'Chinese',
        ]);

        DB::table('elderly_language')->insert([
            'elderly_id' => 1,
            'language' => 'Hokkien',
        ]);

        DB::table('elderly_language')->insert([
            'elderly_id' => 1,
            'language' => 'Teochew',
        ]);
    }
}
