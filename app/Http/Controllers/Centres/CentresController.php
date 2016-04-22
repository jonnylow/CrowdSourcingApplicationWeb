<?php

namespace App\Http\Controllers\Centres;

use Illuminate\Http\Request;

use App\Http\Requests\CreateCentreRequest;
use App\Http\Requests\EditCentreRequest;
use App\Http\Controllers\Controller;
use App\Centre;
use JsValidator;

/**
 * Resource controller that handles the logic when managing location/centre.
 *
 * @package App\Http\Controllers\Centres
 */
class CentresController extends Controller
{
    /**
     * Show the index page for all locations/centres.
     * Responds to requests to GET /centres
     *
     * @return Response
     */
    public function index()
    {
        $centres = Centre::all();

        return view('centres.index', compact('centres'));
    }

    /**
     * Show the form to add a new location/centre.
     * Responds to requests to GET /centres/create
     *
     * @return Response
     */
    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\CreateCentreRequest');

        return view('centres.create', compact('validator'));
    }

    /**
     * Store a new location/centre.
     * Responds to requests to POST /centres
     *
     * @param  \App\Http\Requests\CreateCentreRequest  $request
     * @return Response
     */
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

    /**
     * Show the form to edit a location/centre.
     * Responds to requests to GET /centres/{id}/edit
     *
     * @param  int  $id  the ID of the location/centre
     * @return Response
     */
    public function edit($id)
    {
        $validator = JsValidator::formRequest('App\Http\Requests\EditCentreRequest');

        $centre = Centre::findOrFail($id);

        return view('centres.edit', compact('validator', 'centre'));
    }

    /**
     * Update an existing location/centre.
     * Responds to requests to POST /centres/{id}
     *
     * @param  int  $id  the ID of the location/centre
     * @param  \App\Http\Requests\EditCentreRequest  $request
     * @return Response
     */
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

    /**
     * Get the address information of the given postal code.
     * Responds to requests to POST /postal-to-address
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
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
