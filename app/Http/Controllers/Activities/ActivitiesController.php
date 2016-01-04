<?php

namespace App\Http\Controllers\Activities;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Activity;
use App\Centre;
use App\Elderly;
use App\ElderlyLanguage;
use App\Task;
use Auth;
use Validator;

class ActivitiesController extends Controller
{
    public function index()
    {
        $upcoming = Activity::with('elderly')->ofCentreForStaff(Auth::user())->upcoming()->get();
        $today = Activity::with('elderly')->ofCentreForStaff(Auth::user())->today()->get();
        $past = Activity::with('elderly')->ofCentreForStaff(Auth::user())->past()->get();

        return view('activities.index', compact('upcoming', 'today', 'past'));
    }

    public function show($id)
    {
        $activity = Activity::with('volunteers')->findOrFail($id);

        return view('activities.show', compact('activity'));
    }

    public function create()
    {
        $expectedDuration = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');
        $endLocations = Centre::all()->lists('name', 'centre_id');
        $seniorList = Elderly::all()->lists('elderly_list', 'elderly_id');

        $startLocations = collect($centreList)->sort()->put('others', 'Others');
        $endLocations = collect($endLocations)->sort()->put('others', 'Others');
        $seniorList = collect($seniorList)->sort()->put('others', 'Others');
        $genderList = ['M'=> 'M', 'F' => 'F'];
        $seniorLanguages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        return view('activities.create', compact('centreList', 'expectedDuration', 'startLocations', 'endLocations', 'seniorList', 'genderList', 'seniorLanguages'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'centre'                => 'required|string',
            'date_to_start'         => 'required|date|after:today',
            'time_to_start'         => 'required',
            'duration'              => 'required|numeric|min:1',
            'more_information'      => 'string',
            'start_location'        => 'required|string',
            'start_location_name'   => 'string|required_if:start_location,others',
            'start_postal'          => 'numeric|required_if:start_location,others',
            'end_location'          => 'required|string',
            'end_location_name'     => 'string|required_if:end_location,others',
            'end_postal'            => 'numeric|required_if:end_location,others',
            'senior'                => 'required|string',
            'senior_nric'           => 'string|unique:elderly,nric,null,elderly_id|required_if:senior,others',
            'senior_name'           => 'string|required_if:senior,others',
            'senior_gender'         => 'in:M,F|required_if:senior,others',
            'senior_photo'          => 'image',
            'senior_languages'      => 'array|required_if:senior,others',
            'senior_nok_name'       => 'string|required_if:senior,others',
            'senior_nok_contact'    => 'digits:8|required_if:senior,others',
            'senior_medical'        => 'string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            if(count($request->get('senior_languages')) < 1) {
                return back()
                    ->withErrors('senior_languages', 'The senior language is required if senior is others.')
                    ->withInput();
            }

            $startLocationId = $request->get('start_location');
            $endLocationId = $request->get('end_location');
            $elderlyId = $request->get('senior');

            if($request->get('senior') == "others") {
                $elderly = Elderly::create([
                    'nric'                  => $request->get('senior_nric'),
                    'name'                  => $request->get('senior_name'),
                    'gender'                => $request->get('senior_gender'),
                    'next_of_kin_name'      => $request->get('senior_nok_name'),
                    'next_of_kin_contact'   => $request->get('senior_nok_contact'),
                    'medical_condition'     => $request->get('senior_medical'),
                    'image_photo'           => $request->get('senior_photo'),
                    'centre_id'             => $request->get('centre'),
                ]);

                foreach($request->get('senior_languages') as $language) {
                    ElderlyLanguage::create([
                        'elderly_id'    => $elderly->elderly_id,
                        'language'      => $language,
                    ]);
                }

                $elderlyId = $elderly->elderly_id;
            }

            if($request->get('start_location') == "others") {
                $postal = $request->get('start_postal');
                $geoInfo = json_decode($this->postalCodeToAddress($postal), true);
                $centre = Centre::create([
                    'name'          => $request->get('start_location_name'),
                    'address'       => $geoInfo['address'],
                    'postal_code'   => $postal,
                    'lng'           => $geoInfo['x'],
                    'lat'           => $geoInfo['y'],
                ]);

                $startLocationId = $centre->centre_id;
            }

            if($request->get('end_location') == "others") {
                $postal = $request->get('end_postal');
                $geoInfo = json_decode($this->postalCodeToAddress($postal), true);
                $centre = Centre::create([
                    'name'          => $request->get('end_location_name'),
                    'address'       => $geoInfo['address'],
                    'postal_code'   => $postal,
                    'lng'           => $geoInfo['x'],
                    'lat'           => $geoInfo['y'],
                ]);

                $endLocationId = $centre->centre_id;
            }

            Activity::create([
                'datetime_start'            => $request->get('date_to_start') . " " . $request->get('time_to_start'),
                'expected_duration_minutes' => $request->get('duration'),
                'category'                  => 'transport',
                'more_information'          => $request->get('more_information'),
                'location_from_id'          => $startLocationId,
                'location_to_id'            => $endLocationId,
                'elderly_id'                => $elderlyId,
                'centre_id'                 => $request->get('centre'),
                'staff_id'                  => Auth::user()->staff_id,
            ]);

            return back()->with('success', 'Activity added successfully!');
        }
    }

    public function edit($id)
    {
        $activity = Activity::findOrFail($id);

        return view('activities.edit', compact('activity'));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'               => 'required|string',
            'date_to_start'      => 'required|date',
            'time_to_start'      => 'required',
            'duration'           => 'required|numeric|min:0.1',
            'more_information'   => 'string',
            'location_from'     => 'required|string',
            'location_to'       => 'required|string',
            'elderly_name'        => 'required',
            'next_of_kin_name'    => 'required',
            'next_of_kin_contact' => 'required|digits:8',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $activity = Activity::findOrFail($id);
            $activity->update($request->all());
        }

        return back()->with('success', 'Activity updated successfully!');
    }

    public function setApproval($activityId, $volunteerId, $approval) {
        $tasks = Task::ofActivity($activityId)->get();

        if(strcmp($approval, "reject") == 0) {
            foreach($tasks as $task) {
                if($task->volunteer_id == $volunteerId && $task->approval == "pending") {
                    $task->approval = "Rejected";
                    $task->save();
                    return back()->with('success', 'Volunteer rejected!');;
                }
            }
        } else {
            foreach($tasks as $task) {
                if($task->approval == "pending") {
                    if ($task->volunteer_id == $volunteerId) {
                        $task->approval = "Approved";
                    } else {
                        $task->approval = "Rejected";
                    }
                }
                $task->save();
            }
            return back()->with('success', 'Volunteer approved!');
        }
    }

    public static function getActivityStatus($activityId)
    {
        $tasks = Task::ofActivity($activityId)->get();
        $taskCount = $tasks->count();

        if ($taskCount == 0) {
            return 0; // Not Started
        } else {
            $groupByStatus = $tasks->groupBy('status');

            if ($groupByStatus->has('completed')) {
                return 100; // Completed
            } else if ($groupByStatus->has('pick-up')) {
                return 25; // Picked-up
            } else if ($groupByStatus->has('at check-up')) {
                return 50; // At Check-up
            } else if ($groupByStatus->has('check-up completed')) {
                return 75; // Check-up Completed
            } else {
                return 0; // Not Started
            }
        }
    }

    public static function getApplicantStatus($activityId)
    {
        $tasks = Task::ofActivity($activityId)->get();
        $taskCount = $tasks->count();

        if ($taskCount == 0) {
            return "Not Started";
        } else {
            $groupByStatus = $tasks->groupBy('status');
            $groupByApproval = $tasks->groupBy('approval');

            if ($groupByStatus->has('completed')) {
                return "Completed";
            } else if ($groupByStatus->has('picked-up') ||
                $groupByStatus->has('at check-up') ||
                $groupByStatus->has('check-up completed')
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

    public function postalCodeToAddress($postal)
    {
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
                    $address = $fromLatLng['BLOCK'] . " " . $fromLatLng['ROAD'] . ", " . $fromLatLng['POSTALCODE'] . ", Singapore";
                    $json['neighbourhood'] = ucwords(strtolower($neighbourhood));
                    $json['address'] = ucwords(strtolower($address));

                    return json_encode($json);
                }
            }
        }
    }
}
