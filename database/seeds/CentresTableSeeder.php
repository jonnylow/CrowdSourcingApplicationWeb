<?php

use Illuminate\Database\Seeder;

class CentresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy record
        DB::table('centres')->insert([
            'centre_id' => 1,
            'name' => 'Henderson',
            'address' => '117 Bukit Merah View #01-201',
            'postal_code' => '151117',
            'lng' => 103.82190657700056,
            'lat' => 1.2843010410004467,
        ]);

        DB::table('centres')->insert([
            'centre_id' => 2,
            'name' => 'Dakota Crescent',
            'address' => '62 Dakota Crescent #01-315',
            'postal_code' => '390062',
            'lng' => 103.889069356,
            'lat' => 1.3076509340004,
        ]);

        DB::table('centres')->insert([
            'centre_id' => 3,
            'name' => 'Toa Payoh',
            'address' => '169 Toa Payoh Lorong 1 #01-1052',
            'postal_code' => '310169',
            'lng' => 103.84266425,
            'lat' => 1.3317424160005,
        ]);

        DB::table('centres')->insert([
            'centre_id' => 4,
            'name' => 'Singapore General Hospital',
            'address' => '1 Hospital Drive, 169608, Singapore',
            'postal_code' => '169608',
            'lng' => 103.835499702,
            'lat' => 1.2798006200005,
        ]);

        DB::table('centres')->insert([
            'centre_id' => 5,
            'name' => 'Bukit Merah Polyclinic',
            'address' => '163 Bukit Merah Central, 150163, Singapore',
            'postal_code' => '150163',
            'lng' => 103.816965114,
            'lat' => 1.2837871400004,
        ]);
    }
}
