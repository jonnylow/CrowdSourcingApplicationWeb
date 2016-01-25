<?php

use Illuminate\Database\Seeder;

use App\Centre;

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
        Centre::create([
            'name' => 'Henderson',
            'address' => '117 Bukit Merah View',
            'postal_code' => '151117',
            'lng' => 103.82190657700056,
            'lat' => 1.2843010410004467,
        ]);

        Centre::create([
            'name' => 'Dakota Crescent',
            'address' => '62 Dakota Crescent',
            'postal_code' => '390062',
            'lng' => 103.889069356,
            'lat' => 1.3076509340004,
        ]);

        Centre::create([
            'name' => 'Toa Payoh',
            'address' => '169 Toa Payoh Lorong 1',
            'postal_code' => '310169',
            'lng' => 103.84266425,
            'lat' => 1.3317424160005,
        ]);

        Centre::create([
            'name' => 'Singapore General Hospital',
            'address' => '1 Hospital Drive, 169608, Singapore',
            'postal_code' => '169608',
            'lng' => 103.835499702,
            'lat' => 1.2798006200005,
        ]);

        Centre::create([
            'name' => 'Bukit Merah Polyclinic',
            'address' => '163 Bukit Merah Central, 150163, Singapore',
            'postal_code' => '150163',
            'lng' => 103.816965114,
            'lat' => 1.2837871400004,
        ]);

        Centre::create([
            'name' => 'Queenstown Polyclinic',
            'address' => '580 Stirling Road, 148958, Singapore',
            'postal_code' => '148958',
            'lng' => 103.80115498500055,
            'lat' => 1.2985064950004244,
        ]);
    }
}
