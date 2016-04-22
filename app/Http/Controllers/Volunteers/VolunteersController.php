<?php

namespace App\Http\Controllers\Volunteers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateVolunteerRequest;
use App\Http\Requests\EditVolunteerRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Volunteer;
use App\Rank;
use JsValidator;
use Mail;

/**
 * Resource controller that handles the logic when managing volunteer.
 *
 * @package App\Http\Controllers\Volunteers
 */
class VolunteersController extends Controller
{
    /**
     * Show the index page for all volunteers.
     * Responds to requests to GET /volunteers
     *
     * @return Response
     */
    public function index()
    {
        $volunteers = Volunteer::all();

        return view('volunteers.index', compact('volunteers'));
    }

    /**
     * Show the information for the given volunteer.
     * Responds to requests to GET /volunteers/{id}
     *
     * @param  int  $id  the ID of the volunteer
     * @return Response
     */
    public function show($id)
    {
        $volunteer = Volunteer::with('activities')->findOrFail($id);

        return view('volunteers.show', compact('volunteer'));
    }

    /**
     * Show the form to add a new volunteer.
     * Responds to requests to GET /volunteers/create
     *
     * @return Response
     */
    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\CreateVolunteerRequest');

        $genderList = ['M' => 'Male', 'F' => 'Female'];
        $carType = [false => 'No car', true => 'Has car'];
        $preferenceList = ['Befriend senior citizens', 'Design/Maintain Webpage', 'Lead games/exercises',
            'Organise fund raising activities', 'Organise publicity events', 'Organize social activities',
            'Prepare publicity materials', 'Prepare tea/snacks', 'Written translation for brochures'];
        $preferenceList = array_combine($preferenceList, $preferenceList);
        $preferenceList = collect($preferenceList);
        $preferenceList->prepend("Select a volunteering preference", "");


        return view('volunteers.create', compact('validator', 'genderList', 'carType', 'preferenceList'));
    }

    /**
     * Store a new volunteer.
     * Responds to requests to POST /volunteers
     *
     * @param  \App\Http\Requests\CreateVolunteerRequest  $request
     * @return Response
     */
    public function store(CreateVolunteerRequest $request)
    {
        $randomString = Str::random();

        $volunteer = Volunteer::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => $randomString,
            'gender'  => $request->get('gender'),
            'date_of_birth'  => $request->get('date_of_birth'),
            'contact_no'  => $request->get('contact_no'),
            'occupation'  => $request->get('occupation'),
            'has_car'  => $request->get('car'),
            'area_of_preference_1'  => $request->get('area_of_preference_1'),
            'area_of_preference_2'  => $request->get('area_of_preference_2'),
            'is_approved' => 'approved',
            'rank_id'  => Rank::lowest()->first()->rank_id,
        ]);

        $email = $volunteer->email;

        Mail::send('emails.welcome_volunteer', compact('volunteer', 'randomString'), function ($message) use ($email) {
            $message->subject('Your CareGuide Volunteer account has been registered.');
            $message->bcc('imchosen6@gmail.com');
        });

        return redirect('volunteers')->with('success', 'Volunteers is added successfully!');
    }

    /**
     * Show the form to edit a volunteer.
     * Responds to requests to GET /volunteers/{id}/edit
     *
     * @param  int  $id  the ID of the volunteer
     * @return Response
     */
    public function edit($id)
    {
        $validator = JsValidator::formRequest('App\Http\Requests\EditVolunteerRequest');

        $volunteer = Volunteer::findOrFail($id);
        $genderList = ['M' => 'Male', 'F' => 'Female'];
        $carType = [false => 'No car', true => 'Has car'];
        $preferenceList = ['Befriend senior citizens', 'Design/Maintain Webpage', 'Lead games/exercises',
            'Organise fund raising activities', 'Organise publicity events', 'Organize social activities',
            'Prepare publicity materials', 'Prepare tea/snacks', 'Written translation for brochures'];
        $preferenceList = array_combine($preferenceList, $preferenceList);
        $preferenceList = collect($preferenceList);
        $preferenceList->prepend("Select a volunteering preference", "");

        return view('volunteers.edit', compact('validator', 'volunteer', 'genderList', 'carType', 'preferenceList'));
    }

    /**
     * Update an existing volunteer.
     * Responds to requests to PUT /volunteers/{id}
     *
     * @param  int  $id  the ID of the volunteer
     * @param  \App\Http\Requests\EditVolunteerRequest  $request
     * @return Response
     */
    public function update($id, EditVolunteerRequest $request)
    {
        $volunteer = Volunteer::findOrFail($id);

        $volunteer->update([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'gender'  => $request->get('gender'),
            'date_of_birth'  => $request->get('date_of_birth'),
            'contact_no'  => $request->get('contact_no'),
            'occupation'  => $request->get('occupation'),
            'has_car'  => $request->get('car'),
            'minutes_volunteered'  => $request->get('minutes_volunteered'),
            'area_of_preference_1'  => $request->get('area_of_preference_1'),
            'area_of_preference_2'  => $request->get('area_of_preference_2'),
        ]);

        $email = $volunteer->email;

        Mail::send('emails.volunteer_update', compact('volunteer'), function ($message) use ($email) {
            $message->subject('Your CareGuide account particulars was recently updated.');
            $message->bcc('imchosen6@gmail.com');
        });

        return redirect()->route('volunteers.show', compact('volunteer'))->with('success', 'Volunteer is updated successfully!');
    }

    /**
     * Reject a given volunteer account.
     * Responds to requests to PATCH /volunteers/{id}/reject
     *
     * @param  int  $id  the ID of the volunteer
     * @return Response
     */
    public function rejectVolunteer($id) {
        $volunteer = Volunteer::findOrFail($id);

        if($volunteer->is_approved == 'pending') {
            $volunteer->is_approved = 'rejected';
            $volunteer->save();

            $email = $volunteer->email;

            Mail::send('emails.volunteer_approval', compact('volunteer'), function ($message) use ($email) {
                $message->subject('Your CareGuide Volunteer account has been rejected.');
                $message->bcc('imchosen6@gmail.com');
            });

            return back()->with('success', 'Volunteer is rejected!');
        } else {
            return back()->with('error', 'Volunteer is ' . $volunteer->is_approved . 'already!');
        }
    }

    /**
     * Approve a given volunteer account.
     * Responds to requests to PATCH /volunteers/{id}/approve
     *
     * @param  int  $id  the ID of the volunteer
     * @return Response
     */
    public function approveVolunteer($id) {
        $volunteer = Volunteer::findOrFail($id);

        if($volunteer->is_approved !== 'approved') {
            $volunteer->is_approved = 'approved';
            $volunteer->save();

            $email = $volunteer->email;

            Mail::send('emails.volunteer_approval', compact('volunteer'), function ($message) use ($email) {
                $message->subject('Your CareGuide Volunteer account has been approved.');
                $message->bcc('imchosen6@gmail.com');
            });

            return back()->with('success', 'Volunteer is approved!');
        } else {
            return back()->with('error', 'Volunteer is ' . $volunteer->is_approved . 'already!');
        }
    }
}
