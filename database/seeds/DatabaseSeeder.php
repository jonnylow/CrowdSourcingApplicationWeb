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

        $this->call(RanksTableSeeder::class);
        $this->call(CentresTableSeeder::class);
        $this->call(StaffTableSeeder::class);
        $this->call(CentreStaffTableSeeder::class);
        $this->call(ElderlyTableSeeder::class);
        $this->call(ElderlyLanguageTableSeeder::class);
        $this->call(VolunteersTableSeeder::class);
        $this->call(ActivitiesTableSeeder::class);
        $this->call(TasksTableSeeder::class);

        Model::reguard();
    }
}
