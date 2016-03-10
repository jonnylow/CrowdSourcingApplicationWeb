<?php

namespace App\Http\Controllers\Activities;

use Illuminate\Http\Request;

use App\Http\Requests\ActivityRequest;
use App\Http\Controllers\Controller;
use App\Activity;
use App\Centre;
use App\Elderly;
use App\ElderlyLanguage;
use App\Task;
use Auth;
use Carbon\Carbon;
use JsValidator;
use Mail;
use Validator;

class ActivitiesController extends Controller
{
    public function index()
    {
        $upcoming = Activity::with('elderly')->ofCentreForStaff(Auth::user())
            ->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where('tasks.status', '<>', 'completed')
            ->orWhere('datetime_start', '>', Carbon::now()->endOfDay())
            ->oldest('datetime_start')->get();

        $today = Activity::with('elderly')->ofCentreForStaff(Auth::user())
            ->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->whereBetween('datetime_start', [Carbon::today(), Carbon::now()->endOfDay()])
            ->orWhere('tasks.status', '<>', 'completed')
            ->oldest('datetime_start')->get();

        $past = Activity::with('elderly')->ofCentreForStaff(Auth::user())
            ->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where('tasks.status', 'completed')
            ->orWhere('datetime_start', '<', Carbon::today())
            ->latest('datetime_start')->get();

        return view('activities.index', compact('upcoming', 'today', 'past'));
    }

    public function show($id)
    {
        $activity = Activity::with('volunteers')->findOrFail($id);

        return view('activities.show', compact('activity'));
    }

    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\ActivityRequest');

        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');
        $locationList = Centre::all()->lists('name', 'centre_id');
        $seniorList = Elderly::all()->lists('elderly_list', 'elderly_id');

        $timePeriodList = ['AM' => 'AM', 'PM' => 'PM'];
        $locationList = $locationList->sort()->put('others', 'Others');
        $seniorList = $seniorList->sort()->put('others', 'Others');
        $genderList = ['M' => 'Male', 'F' => 'Female'];
        $seniorLanguages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        return view('activities.create', compact('validator', 'centreList', 'timePeriodList', 'locationList', 'seniorList', 'genderList', 'seniorLanguages'));
    }

    public function store(ActivityRequest $request)
    {
        $errors = array();

        $startLocationId = $request->get('start_location');
        $endLocationId = $request->get('end_location');
        $elderlyId = $request->get('senior');

        $startLocation = new Centre;
        $endLocation = new Centre;
        $elderly = new Elderly;

        if($request->get('start_location') == "others") {
            $postal = $request->get('start_postal');
            $geoInfo = json_decode($this->postalCodeToAddress($postal), true);

            if($geoInfo['status'] == 'ok') {
                $startLocation->name = ucwords(strtolower($request->get('start_location_name')));
                $startLocation->address = $geoInfo['address'];
                $startLocation->postal_code = $postal;
                $startLocation->lng = $geoInfo['x'];
                $startLocation->lat = $geoInfo['y'];
            } else {
                $errors = array_add($errors, 'start_location', 'Start postal code does not exist.');
            }
        }

        if($request->get('end_location') == "others") {
            if($request->get('start_location_name') == $request->get('end_location_name')) {
                $endLocation = $startLocation;
            } else {
                $postal = $request->get('end_postal');
                $geoInfo = json_decode($this->postalCodeToAddress($postal), true);

                if ($geoInfo['status'] == 'ok') {
                    $endLocation->name = ucwords(strtolower($request->get('end_location_name')));
                    $endLocation->address = $geoInfo['address'];
                    $endLocation->postal_code = $postal;
                    $endLocation->lng = $geoInfo['x'];
                    $endLocation->lat = $geoInfo['y'];
                } else {
                    $errors = array_add($errors, 'end_location', 'End postal code does not exist.');
                }
            }
        }

        if($request->get('senior') == "others") {
            $elderly->nric = $request->get('senior_nric');
            $elderly->name = $request->get('senior_name');
            $elderly->gender = $request->get('senior_gender');
            $elderly->birth_year = $request->get('senior_birth_year');
            $elderly->next_of_kin_name = $request->get('senior_nok_name');
            $elderly->next_of_kin_contact = $request->get('senior_nok_contact');
            $elderly->medical_condition = $request->get('senior_medical');
            $elderly->centre_id = $request->get('centre');

            if(count($request->get('languages')) < 1) {
                $errors = array_add($errors, 'languages', 'Language is required.');
            } else {
                foreach($request->get('languages') as $language) {
                    $v = Validator::make(['language' => $language], ['language' => 'alpha']);
                    if ($v->fails()) {
                        $errors = array_add($errors, 'languages', 'Language must be valid word.');
                    }
                }
            }
        }

        if(count($errors) > 0) {
            return back()
                ->withErrors($errors)
                ->withInput();
        } else {
            if($request->get('start_location') == "others") {
                $startLocation->save();
                $startLocationId = $startLocation->centre_id;
            }

            if($request->get('end_location') == "others") {
                $endLocation->save();
                $endLocationId = $endLocation->centre_id;
            }

            if($request->get('senior') == "others") {
                $elderly->save();
                foreach($request->get('languages') as $language) {
                    ElderlyLanguage::create([
                        'elderly_id'    => $elderly->elderly_id,
                        'language'      => $language,
                    ]);
                }
                $elderlyId = $elderly->elderly_id;
            }

            Activity::create([
                'datetime_start'            => $request->get('date') . " " . $request->get('time'),
                'expected_duration_minutes' => $request->get('duration'),
                'category'                  => 'transport', // Fixed to transport category
                'more_information'          => $request->get('more_information'),
                'location_from_id'          => $startLocationId,
                'location_to_id'            => $endLocationId,
                'elderly_id'                => $elderlyId,
                'centre_id'                 => $request->get('centre'),
                'staff_id'                  => Auth::user()->staff_id,
            ]);

            return redirect('activities')->with('success', 'Activity is added successfully!');
        }
    }

    public function edit($id)
    {
        $validator = JsValidator::formRequest('App\Http\Requests\ActivityRequest');

        $activity = Activity::findOrFail($id);
        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');
        $locationList = Centre::all()->lists('name', 'centre_id');
        $seniorList = Elderly::all()->lists('elderly_list', 'elderly_id');

        $timePeriodList = ['AM' => 'AM', 'PM' => 'PM'];
        $locationList = $locationList->sort()->put('others', 'Others');
        $seniorList = $seniorList->sort()->put('others', 'Others');
        $genderList = ['M' => 'Male', 'F' => 'Female'];
        $seniorLanguages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        return view('activities.edit', compact('validator', 'activity', 'centreList', 'timePeriodList', 'locationList', 'seniorList', 'genderList', 'seniorLanguages'));
    }

    public function update($id, ActivityRequest $request)
    {
        $errors = array();

        $startLocationId = $request->get('start_location');
        $endLocationId = $request->get('end_location');
        $elderlyId = $request->get('senior');

        $startLocation = new Centre;
        $endLocation = new Centre;
        $elderly = new Elderly;

        if($request->get('start_location') == "others") {
            $postal = $request->get('start_postal');
            $geoInfo = json_decode($this->postalCodeToAddress($postal), true);

            if($geoInfo['status'] == 'ok') {
                $startLocation->name = ucwords(strtolower($request->get('start_location_name')));
                $startLocation->address = $geoInfo['address'];
                $startLocation->postal_code = $postal;
                $startLocation->lng = $geoInfo['x'];
                $startLocation->lat = $geoInfo['y'];
            } else {
                $errors = array_add($errors, 'start_location', 'Start postal code does not exist.');
            }
        }

        if($request->get('end_location') == "others") {
            if($request->get('start_location_name') == $request->get('end_location_name')) {
                $endLocation = $startLocation;
            } else {
                $postal = $request->get('end_postal');
                $geoInfo = json_decode($this->postalCodeToAddress($postal), true);

                if ($geoInfo['status'] == 'ok') {
                    $endLocation->name = ucwords(strtolower($request->get('end_location_name')));
                    $endLocation->address = $geoInfo['address'];
                    $endLocation->postal_code = $postal;
                    $endLocation->lng = $geoInfo['x'];
                    $endLocation->lat = $geoInfo['y'];
                } else {
                    $errors = array_add($errors, 'end_location', 'End postal code does not exist.');
                }
            }
        }

        if($request->get('senior') == "others") {
            $elderly->nric = $request->get('senior_nric');
            $elderly->name = $request->get('senior_name');
            $elderly->gender = $request->get('senior_gender');
            $elderly->birth_year = $request->get('senior_birth_year');
            $elderly->next_of_kin_name = $request->get('senior_nok_name');
            $elderly->next_of_kin_contact = $request->get('senior_nok_contact');
            $elderly->medical_condition = $request->get('senior_medical');
            $elderly->centre_id = $request->get('centre');

            if(count($request->get('languages')) < 1) {
                $errors = array_add($errors, 'languages', 'Language is required.');
            } else {
                foreach($request->get('languages') as $language) {
                    $v = Validator::make(['language' => $language], ['language' => 'alpha']);
                    if ($v->fails()) {
                        $errors = array_add($errors, 'languages', 'Language must be valid word.');
                    }
                }
            }
        }

        if(count($errors) > 0) {
            return back()
                ->withErrors($errors)
                ->withInput();
        } else {
            if($request->get('start_location') == "others") {
                $startLocation->save();
                $startLocationId = $startLocation->centre_id;
            }

            if($request->get('end_location') == "others") {
                $endLocation->save();
                $endLocationId = $endLocation->centre_id;
            }

            if($request->get('senior') == "others") {
                $elderly->save();
                foreach($request->get('languages') as $language) {
                    ElderlyLanguage::create([
                        'elderly_id'    => $elderly->elderly_id,
                        'language'      => $language,
                    ]);
                }
                $elderlyId = $elderly->elderly_id;
            }

            $activity = Activity::findOrFail($id);
            $activity->update([
                'datetime_start'            => $request->get('date') . " " . $request->get('time'),
                'expected_duration_minutes' => $request->get('duration'),
                'category'                  => 'transport', // Fixed to transport category
                'more_information'          => $request->get('more_information'),
                'location_from_id'          => $startLocationId,
                'location_to_id'            => $endLocationId,
                'elderly_id'                => $elderlyId,
                'centre_id'                 => $request->get('centre'),
                'staff_id'                  => Auth::user()->staff_id,
            ]);

            return back()->with('success', 'Activity is updated successfully!');
        }
    }

    public function destroy($id)
    {
        $activity = Activity::with('volunteers')->findOrFail($id);

        foreach ($activity->volunteers as $volunteer) {
            if($volunteer->pivot->approval == "pending" || $volunteer->pivot->approval == "approved") {
                $volunteer->pivot->comment = "Activity is cancelled.";
                $volunteer->pivot->approval = "rejected";
                $volunteer->pivot->save();

                $approval = $volunteer->pivot->approval;
                $reason = $volunteer->pivot->comment;

                Mail::send('emails.activity_reject', compact('activity', 'approval', 'reason'), function ($message) {
                    $message->from('imchosen6@gmail.com', 'CareGuide Activity Management');
                    $message->subject('Your application for CareGuide activity has been rejected.');
                    $message->to('imchosen6@gmail.com');
                });
            }
        }
        $activity->delete();

        return redirect('activities')->with('success', 'Activity is cancelled successfully!');
    }

    public function showCancelled()
    {
        $activities = Activity::with('elderly')->cancelled()->ofCentreForStaff(Auth::user())->get();

        return view('activities.cancelled', compact('activities'));
    }

    public function rejectVolunteer($activityId, $volunteerId, Request $request) {
        $task = Task::where('activity_id', $activityId)
            ->where('volunteer_id', $volunteerId)
            ->where('approval', 'pending')
            ->firstOrFail();

        if($request->has('comment')) {
            $task->comment = $request->get('comment');
        } else {
            $task->comment = "The position is unavailable."; // Default message if rejection reason is left blank by staff
        }

        $task->approval = "rejected";
        $task->save();

        $activity = $task->activity;
        $approval = $task->approval;
        $reason = $task->comment;

        Mail::send('emails.activity_reject', compact('activity', 'approval', 'reason'), function ($message) {
            $message->from('imchosen6@gmail.com', 'CareGuide Activity Management');
            $message->subject('Your application for CareGuide activity has been rejected.');
            $message->to('imchosen6@gmail.com');
        });

        return back()->with('success', 'Volunteer is rejected!');
    }

    public function approveVolunteer($activityId, $volunteerId) {
        $tasks = Task::ofActivity($activityId)->get();
        $activity = Activity::findOrFail($activityId);

        foreach($tasks as $task) {
            if($task->approval == "pending") {
                if ($task->volunteer_id == $volunteerId) {
                    $task->approval = "approved";

                } else {
                    $task->comment = "Activity is taken up by another volunteer.";
                    $task->approval = "rejected";
                }
            }
            $task->save();

            $approval = $task->approval;
            $reason = $task->comment;

            Mail::send('emails.activity_reject', compact('activity', 'approval', 'reason'), function ($message) {
                $message->from('imchosen6@gmail.com', 'CareGuide Activity Management');
                $message->subject('Your application for CareGuide activity has been rejected.');
                $message->to('imchosen6@gmail.com');
            });
        }

        Mail::send('emails.activity_approve', compact('activity', 'approval'), function ($message) {
            $message->from('imchosen6@gmail.com', 'CareGuide Activity Management');
            $message->subject('Your application for CareGuide activity has been approved.');
            $message->to('imchosen6@gmail.com');
        });

        return back()->with('success', 'Volunteer is approved!');
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
        } else {
            return json_encode(['status' => 'error']);
        }
    }
}
