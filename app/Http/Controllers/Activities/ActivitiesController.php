<?php

namespace App\Http\Controllers\Activities;

use Illuminate\Http\Request;

use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\EditActivityRequest;
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

/**
 * Resource controller that handles the logic when managing activity.
 *
 * @package App\Http\Controllers\Activities
 */
class ActivitiesController extends Controller
{
    /**
     * Instantiate a new ActivitiesController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply the activities.centre middleware to only show, edit, update, destroy, rejectVolunteer and approveVolunteer methods.
        // We only allow admin, or regular staff from the same centre, to access them.
        $this->middleware('activities.centre', ['only' => ['show', 'edit', 'update', 'destroy', 'rejectVolunteer', 'approveVolunteer']]);

        // Apply the activities.edit middleware to only edit and update methods.
        // We only allow staff to edit activity that has no applicant and starts in the future.
        $this->middleware('activities.edit', ['only' => ['edit', 'update']]);
    }

    /**
     * Show the index page for all activities.
     * Responds to requests to GET /activities
     *
     * @return Response
     */
    public function index()
    {
        $completedActivities = Activity::join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where('tasks.status', 'completed')->lists('activities.activity_id')->toArray();

        if (Auth::user()->is_admin) { // No centre restriction if authenticated user is an admin
            $upcoming = Activity::with('elderly')
                ->whereNotIn('activity_id', $completedActivities)
                ->where('datetime_start', '>', Carbon::now()->endOfDay())
                ->oldest('datetime_start')->get();

            $today = Activity::with('elderly')
                ->whereNotIn('activity_id', $completedActivities)
                ->whereBetween('datetime_start', [Carbon::today(), Carbon::now()->endOfDay()])
                ->oldest('datetime_start')->get();

            $past = Activity::with('elderly')
                ->where(function ($query) use ($completedActivities) {
                    $query->whereIn('activity_id', $completedActivities)
                        ->orWhere('datetime_start', '<', Carbon::today());
                })->latest('datetime_start')->get();
        } else { // Show only activities that belong to the centre the authenticated user (non-admin) is in charge in
            $upcoming = Activity::with('elderly')->ofCentreForStaff(Auth::user())
                ->whereNotIn('activity_id', $completedActivities)
                ->where('datetime_start', '>', Carbon::now()->endOfDay())
                ->oldest('datetime_start')->get();

            $today = Activity::with('elderly')->ofCentreForStaff(Auth::user())
                ->whereNotIn('activity_id', $completedActivities)
                ->whereBetween('datetime_start', [Carbon::today(), Carbon::now()->endOfDay()])
                ->oldest('datetime_start')->get();

            $past = Activity::with('elderly')->ofCentreForStaff(Auth::user())
                ->where(function ($query) use ($completedActivities) {
                    $query->whereIn('activity_id', $completedActivities)
                        ->orWhere('datetime_start', '<', Carbon::today());
                })->latest('datetime_start')->get();
        }

        return view('activities.index', compact('upcoming', 'today', 'past'));
    }

    /**
     * Show the information for the given activity.
     * Responds to requests to GET /activities/{id}
     *
     * @param  int  $id  the ID of the activity
     * @return Response
     */
    public function show($id)
    {
        $activity = Activity::with('volunteers')->findOrFail($id);

        return view('activities.show', compact('activity'));
    }

    /**
     * Show the form to add a new activity.
     * Responds to requests to GET /activities/create
     *
     * @return Response
     */
    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\CreateActivityRequest');

        if (Auth::user()->is_admin)
            $centreList = Centre::all()->lists('name', 'centre_id')->sort();
        else
            $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id')->sort();

        $locationList = Centre::all()->lists('name', 'centre_id');
        $seniorList = Elderly::all()->lists('elderly_list', 'elderly_id');

        $timePeriodList = ['AM' => 'AM', 'PM' => 'PM'];
        $locationList = $locationList->sort()->put('others', 'Others');
        $seniorList = $seniorList->sort()->put('others', 'Others');
        $genderList = ['M' => 'Male', 'F' => 'Female'];
        $seniorLanguages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        return view('activities.create', compact('validator', 'centreList', 'timePeriodList', 'locationList', 'seniorList', 'genderList', 'seniorLanguages'));
    }

    /**
     * Store a new activity.
     * Responds to requests to POST /activities
     *
     * @param  \App\Http\Requests\CreateActivityRequest  $request
     * @return Response
     */
    public function store(CreateActivityRequest $request)
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
                $errors = array_add($errors, 'start_location', 'Postal code for branch does not exist.');
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
                    $errors = array_add($errors, 'end_location', 'Postal code for appointment venue does not exist.');
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
                        $errors = array_add($errors, 'languages', 'Language must be valid words.');
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

    /**
     * Show the form to edit an activity.
     * Responds to requests to GET /activities/{id}/edit
     *
     * @param  int  $id  the ID of the activity
     * @return Response
     */
    public function edit($id)
    {
        $validator = JsValidator::formRequest('App\Http\Requests\EditActivityRequest');

        $activity = Activity::findOrFail($id);

        if (Auth::user()->is_admin)
            $centreList = Centre::all()->lists('name', 'centre_id')->sort();
        else
            $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id')->sort();

        $locationList = Centre::all()->lists('name', 'centre_id');
        $seniorList = Elderly::all()->lists('elderly_list', 'elderly_id');

        $timePeriodList = ['AM' => 'AM', 'PM' => 'PM'];
        $locationList = $locationList->sort()->put('others', 'Others');
        $seniorList = $seniorList->sort()->put('others', 'Others');
        $genderList = ['M' => 'Male', 'F' => 'Female'];
        $seniorLanguages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        return view('activities.edit', compact('validator', 'activity', 'centreList', 'timePeriodList', 'locationList', 'seniorList', 'genderList', 'seniorLanguages'));
    }

    /**
     * Update an existing activity.
     * Responds to requests to PUT /activities/{id}
     *
     * @param  int  $id  the ID of the activity
     * @param  \App\Http\Requests\EditActivityRequest  $request
     * @return Response
     */
    public function update($id, EditActivityRequest $request)
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
                $errors = array_add($errors, 'start_location', 'Postal code for branch does not exist.');
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
                    $errors = array_add($errors, 'end_location', 'Postal code for appointment venue does not exist.');
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
                        $errors = array_add($errors, 'languages', 'Language must be valid words.');
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

            return redirect()->route('activities.show', compact('activity'))->with('success', 'Activity is updated successfully!');
        }
    }

    /**
     * Delete an activity.
     * Responds to requests to DELETE /activities/{id}
     *
     * @param  int  $id  the ID of the activity
     * @return Response
     */
    public function destroy($id)
    {
        $activity = Activity::with('volunteers')->findOrFail($id);
        $reason = "Activity is cancelled.";
        $mailingList = array();

        foreach ($activity->volunteers as $volunteer) {
            if($volunteer->pivot->approval == "pending" || $volunteer->pivot->approval == "approved") {
                array_push($mailingList, $volunteer->email);

                $volunteer->pivot->comment = $reason;
                $volunteer->pivot->approval = "rejected";
                $volunteer->pivot->save();
            }
        }
        $activity->delete();

        Mail::send('emails.activity_reject', compact('activity', 'reason'), function ($message) use ($mailingList) {
            $message->subject('Your application for an CareGuide activity has been rejected.');
            $message->bcc($mailingList);
        });

        return redirect('activities')->with('success', 'Activity is cancelled successfully!');
    }

    /**
     * Show all deleted activities.
     * Responds to requests to GET /activities/cancelled
     *
     * @return Response
     */
    public function showCancelled()
    {
        $activities = Activity::with('elderly')->cancelled()->ofCentreForStaff(Auth::user())->get();

        return view('activities.cancelled', compact('activities'));
    }

    /**
     * Reject a given volunteer for the given activity.
     * Responds to requests to PATCH /activities/{activityId}/reject/{volunteerId}
     *
     * @param  int  $activityId  the ID of the activity
     * @param  int  $volunteerId  the ID of the volunteer
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function rejectVolunteer($activityId, $volunteerId, Request $request) {
        $task = Task::where('activity_id', $activityId)
            ->where('volunteer_id', $volunteerId)
            ->where('approval', 'pending')
            ->firstOrFail();

        $reason = "The position is unavailable."; // Default message if rejection reason is left blank by staff

        if($request->has('comment')) {
            $reason = $request->get('comment');
        }

        $task->comment = $reason;
        $task->approval = "rejected";
        $task->save();

        $activity = $task->activity;
        $email = $task->volunteer->email;

        Mail::send('emails.activity_reject', compact('activity', 'reason'), function ($message) use ($email) {
            $message->subject('Your application for an CareGuide activity has been rejected.');
            $message->bcc($email);
        });

        return back()->with('success', 'Volunteer is rejected!');
    }

    /**
     * Approve a given volunteer for the given activity.
     * Responds to requests to PATCH /activities/{activityId}/approve/{volunteerId}
     *
     * @param  int  $activityId  the ID of the activity
     * @param  int  $volunteerId  the ID of the volunteer
     * @return Response
     */
    public function approveVolunteer($activityId, $volunteerId) {
        $tasks = Task::ofActivity($activityId)->get();
        $activity = Activity::findOrFail($activityId);

        $reason = "Activity is taken up by another volunteer."; // Default reason by system
        $rejectMailingList = array();
        $acceptEmail = "";

        foreach($tasks as $task) {
            if($task->approval == "pending") {
                $email = $task->volunteer->email;

                if ($task->volunteer_id == $volunteerId) {
                    $task->approval = "approved";
                    $acceptEmail = $email;
                } else {
                    $task->comment = $reason;
                    $task->approval = "rejected";
                    array_push($rejectMailingList, $email);
                }
            }
            $task->save();
        }

        if ( ! empty($rejectMailingList)) {
            Mail::send('emails.activity_reject', compact('activity', 'reason'), function ($message) use ($rejectMailingList) {
                $message->subject('Your application for an CareGuide activity has been rejected.');
                $message->bcc($rejectMailingList);
            });
        }

        if ( ! empty($acceptEmail)) {
            Mail::send('emails.activity_approve', compact('activity'), function ($message) use ($acceptEmail) {
                $message->subject('Your application for an CareGuide activity has been accepted.');
                $message->bcc($acceptEmail);
            });
        }

        return back()->with('success', 'Volunteer is approved!');
    }

    /**
     * Get the progress of the given activity.
     * Responds to requests to GET /activities/{id}/progress
     *
     * @param  int  $activityId  the ID of the activity
     * @return JSON
     */
    public function retrieveProgress($activityId)
    {
        $activity = Activity::findOrFail($activityId);

        return json_encode(['progress' => $activity->getProgress()]);
    }

    /**
     * Get the address information of the given postal code.
     *
     * @param  string  $postal  the postal code to lookup
     * @return JSON
     */
    private function postalCodeToAddress($postal)
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
