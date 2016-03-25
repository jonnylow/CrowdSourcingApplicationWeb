<?php

namespace App\Http\Controllers\Centres;

use Illuminate\Http\Request;

use App\Http\Requests\CreateCentreRequest;
use App\Http\Requests\EditCentreRequest;
use App\Http\Controllers\Controller;
use App\Centre;
use JsValidator;

class CentresController extends Controller
{
    public function index()
    {
        $centres = Centre::all();

        return view('centres.index', compact('centres'));
    }

    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\CreateCentreRequest');

        return view('centres.create', compact('validator'));
    }

    public function store(CreateCentreRequest $request)
    {
        $errors = array();
        $geoInfo = json_decode($this->postalCodeToAddress($request), true);

        if ($geoInfo['status'] == 'error') {
            $errors = array_add($errors, 'postal', 'Postal code does not exist.');
        }

        if(count($errors) > 0) {
            return back()
                ->withErrors($errors)
                ->withInput();
        } else {
            Centre::create([
                'name' => $request->get('name'),
                'address' => $request->get('address_full'),
                'postal_code' => $request->get('postal'),
                'lng' => $geoInfo['x'],
                'lat' => $geoInfo['y'],
            ]);

            return redirect('centres')->with('success', 'Location is added successfully!');
        }
    }

    public function edit($id)
    {
        $validator = JsValidator::formRequest('App\Http\Requests\EditCentreRequest');

        $centre = Centre::findOrFail($id);

        return view('centres.edit', compact('validator', 'centre'));
    }

    public function update($id, EditCentreRequest $request)
    {
        $errors = array();
        $geoInfo = json_decode($this->postalCodeToAddress($request), true);

        if ($geoInfo['status'] == 'error') {
            $errors = array_add($errors, 'postal', 'Postal code does not exist.');
        }

        if(count($errors) > 0) {
            return back()
                ->withErrors($errors)
                ->withInput();
        } else {
            $centre = Centre::findOrFail($id);
            $centre->update([
                'name' => $request->get('name'),
                'address' => $request->get('address'),
                'postal_code' => $request->get('postal'),
                'lng' => $geoInfo['x'],
                'lat' => $geoInfo['y'],
            ]);

            return redirect('centres')->with('success', 'Location is updated successfully!');
        }
    }

    public function destroy($id)
    {
        $centre = Centre::findOrFail($id);
        $centre->delete();

        return back()->with('success', 'Location is removed successfully!');
    }

    public function postalCodeToAddress(Request $request)
    {
        $postal = $request->get('postal');

        $client = new \GuzzleHttp\Client();
        $responseFromPostal = $client->get('http://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?f=pjson&countryCode=SGP&maxLocations=1&outFields=*&category=postal&postal=' . $postal);
        $responseFromPostal = json_decode($responseFromPostal->getBody(), true);
        if (count($responseFromPostal['candidates'])) {
            $json['status'] = 'ok';
            $fromPostal = $responseFromPostal['candidates'][0]['location'];

            $lat = $fromPostal['y'];
            $lng = $fromPostal['x'];
            $json['x'] = $lng;
            $json['y'] = $lat;

            $responseFromLatLng = $client->get('http://www.onemap.sg/API/services.svc/revgeocode?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&location=' . $lng . ',' . $lat);
            $responseFromLatLng = json_decode($responseFromLatLng->getBody(), true);

            if (count($responseFromLatLng['GeocodeInfo'])) {
                $fromLatLng = $responseFromLatLng['GeocodeInfo'][0];

                $neighbourhood = $fromLatLng['BUILDINGNAME'];
                $address = $fromLatLng['BLOCK'] . " " . $fromLatLng['ROAD'] . ", Singapore " . $fromLatLng['POSTALCODE'];
                $json['neighbourhood'] = ucwords(strtolower($neighbourhood));
                $json['address'] = ucwords(strtolower($address));

                return json_encode($json);
            }
        } else {
            return json_encode(['status' => 'error']);
        }
    }
}
