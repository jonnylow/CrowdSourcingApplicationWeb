<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(SeniorCentresTableSeeder::class);
        $this->call(RanksTableSeeder::class);
        $this->call(StaffTableSeeder::class);
        $this->call(VolunteersTableSeeder::class);
        $this->call(ElderlyTableSeeder::class);
        $this->call(ActivitiesTableSeeder::class);
        $this->call(ElderlyLanguageTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(SeniorCentreStaffTableSeeder::class);

        Model::reguard();
    }
}
