<?php

namespace App\Http\Controllers\Activities;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Activity;
use App\Task;
use Auth;
use Validator;

class ActivitiesController extends Controller
{
    public function index()
    {
        $upcoming = Activity::ofSeniorCentre(Auth::user()->senior_centre_id)->upcoming()->get();
        $today = Activity::ofSeniorCentre(Auth::user()->senior_centre_id)->today()->get();
        $past = Activity::ofSeniorCentre(Auth::user()->senior_centre_id)->past()->get();

        return view('activities.index', compact('upcoming', 'today', 'past'));
    }

    public function show($id)
    {
        $activity = Activity::findOrFail($id);

        return view('activities.show', compact('activity'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $hiddenInputs = $request->only(['activity_name_1', 'activity_name_2', 'start_location_lat',
            'start_location_lng', 'end_location_lat', 'end_location_lng']);

        $validator = Validator::make($request->all(), [
            'date_to_start'      => 'required|date|after:today',
            'time_to_start'      => 'required',
            'duration'           => 'required|numeric|min:0',
            'more_information'   => 'string',
            'start_location'     => 'required|string',
            'end_location'       => 'required|string',
            'senior_name'        => 'required',
            'senior_nok_name'    => 'required',
            'senior_nok_contact' => 'required|digits:8',
        ]);

        if (array_has($hiddenInputs, 'activity_name_1') &&
            array_has($hiddenInputs, 'activity_name_2') &&
            array_has($hiddenInputs, 'start_location_lat') &&
            array_has($hiddenInputs, 'start_location_lng') &&
            array_has($hiddenInputs, 'end_location_lat') &&
            array_has($hiddenInputs, 'end_location_lng')
        ) {
            $activityName = $hiddenInputs['activity_name_1'] . " to " . $hiddenInputs['activity_name_2'];
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            Activity::create([
                'name'                      => $activityName,
                'location_from'             => $request->get('start_location'),
                'location_from_long'        => $hiddenInputs['start_location_lng'],
                'location_from_lat'         => $hiddenInputs['start_location_lat'],
                'location_to'               => $request->get('end_location'),
                'location_to_long'          => $hiddenInputs['end_location_lng'],
                'location_to_lat'           => $hiddenInputs['end_location_lat'],
                'datetime_start'            => $request->get('date_to_start') . " " . $request->get('time_to_start'),
                'expected_duration_minutes' => $request->get('duration'),
                'more_information'          => $request->get('more_information'),
                'elderly_name'              => $request->get('senior_name'),
                'next_of_kin_name'          => $request->get('senior_nok_name'),
                'next_of_kin_contact'       => $request->get('senior_nok_contact'),
                'senior_centre_id'          => Auth::user()->seniorCentre->senior_centre_id,
                'vwo_user_id'               => Auth::user()->vwo_user_id,
            ]);

            return back()->with('success', 'Activity added successfully!');
        }
    }

    public static function getStatus($activityId)
    {
        $tasks = Task::ofActivity($activityId)->get();
        $taskCount = $tasks->count();

        if ($taskCount == 0) {
            return "0 Volunteer Applied";
        } else {
            $groupByStatus = $tasks->groupBy('status');
            $groupByApproval = $tasks->groupBy('approval');

            if ($groupByStatus->has('Completed')) {
                return "Completed";
            } else if ($groupByStatus->has('Picked Up') ||
                $groupByStatus->has('At Check-up') ||
                $groupByStatus->has('Check-up Completed')
            ) {
                return "In-Progress";
            } else if ($groupByApproval->has('approved')) {
                return "Volunteer Approved";
            } else if ($groupByApproval->has('pending')) {
                return $groupByApproval->all()['pending']->count() . " Application(s) Received";
            } else if ($groupByApproval->has('withdrawn')) {
                return $groupByApproval->all()['withdrawn']->count() . " Application(s) Withdrawn";
            } else if ($groupByApproval->has('rejected')) {
                return $groupByApproval->all()['rejected']->count() . " Application(s) Rejected";
            }
        }
    }

    public function addressToLatLng($address)
    {
        $validator = Validator::make([$address], [
            'address' => 'required|string',
        ]);

        if ($validator->passes()) {
            $client = new \GuzzleHttp\Client();
            $responseFromAddr = $client->get('http://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?f=pjson&countryCode=SGP&maxLocations=1&outFields=*&address=' . $address);
            $responseFromAddr = json_decode($responseFromAddr->getBody(), true);
            if (count($responseFromAddr['candidates'])) {
                $response = $responseFromAddr['candidates'][0]['location'];
                $json['x'] = $response['x'];
                $json['y'] = $response['y'];

                return json_encode($json);
            }
        }
    }

    public function postalCodeToAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'postal' => 'required|digits:6',
        ]);

        if ($validator->passes()) {
            $postal = $request->input('postal');
            $client = new \GuzzleHttp\Client();
            $responseFromPostal = $client->get('http://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?f=pjson&countryCode=SGP&maxLocations=1&outFields=*&category=postal&postal=' . $postal);
            $responseFromPostal = json_decode($responseFromPostal->getBody(), true);
            if (count($responseFromPostal['candidates'])) {
                $fromPostal = $responseFromPostal['candidates'][0]['location'];

                $lat = $fromPostal['y'];
                $lng = $fromPostal['x'];
                $json['x'] = $lng;
                $json['y'] = $lat;

                $responseFromLatLng = $client->get('http://www.onemap.sg/API/services.svc/revgeocode?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&location=' . $lng . ',' . $lat);
                $responseFromLatLng = json_decode($responseFromLatLng->getBody(), true);

                if (count($responseFromLatLng['GeocodeInfo'])) {
                    $fromLatLng = $responseFromLatLng['GeocodeInfo'][0];

                    if (empty($fromLatLng['BUILDINGNAME']) || strpos($fromLatLng['BUILDINGNAME'], "HDB") !== false) {
                        $responseFromLatLng = $client->get('http://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?f=pjson&location=' . $lng . ',' . $lat);
                        $responseFromLatLng = json_decode($responseFromLatLng->getBody(), true);

                        if (isset($responseFromLatLng['address'])) {
                            $neighbourhood = $responseFromLatLng['address']['Address'];
                            $address = $responseFromLatLng['address']['Match_addr'];
                            $json['neighbourhood'] = ucwords(strtolower($neighbourhood));
                            $json['address'] = ucwords(strtolower($address));

                            return json_encode($json);
                        }
                    } else {
                        $neighbourhood = $fromLatLng['BUILDINGNAME'];
                        $address = $fromLatLng['BUILDINGNAME'] . "\n" . $fromLatLng['BLOCK'] . " " . $fromLatLng['ROAD'] . ", " . $fromLatLng['POSTALCODE'] . ", Singapore";
                        $json['neighbourhood'] = ucwords(strtolower($neighbourhood));
                        $json['address'] = ucwords(strtolower($address));

                        return json_encode($json);
                    }
                }
            }
        }
    }
}
