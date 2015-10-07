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
        $this->call(VwoUsersTableSeeder::class);
        $this->call(VolunteersTableSeeder::class);
        $this->call(ActivitiesTableSeeder::class);
        $this->call(TasksTableSeeder::class);

        Model::reguard();
    }
}
