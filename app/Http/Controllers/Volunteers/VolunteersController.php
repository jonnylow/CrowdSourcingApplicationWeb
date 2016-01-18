<?php

namespace App\Http\Controllers\Volunteers;

use Illuminate\Http\Request;

use App\Http\Requests\VolunteerRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Volunteer;
use App\Rank;
use JsValidator;
use Mail;

class VolunteersController extends Controller
{
    public function index()
    {
        $volunteers = Volunteer::all();

        return view('volunteers.index', compact('volunteers'));
    }

    public function show($id)
    {
        $volunteer = Volunteer::with('activities')->findOrFail($id);

        return view('volunteers.show', compact('volunteer'));
    }

    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\VolunteerRequest');

        $genderList = ['M'=> 'Male', 'F' => 'Female'];

        return view('volunteers.create', compact('validator', 'genderList'));
    }

    public function store(VolunteerRequest $request)
    {
        $randomString = Str::random();

        $volunteer = Volunteer::create([
            'nric'      => $request->get('nric'),
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
            'rank_id'  => Rank::lowest()->first()->rank_id,
        ]);

        Mail::send('emails.welcome', compact('volunteer', 'randomString'), function ($message) {
            $message->from('imchosen6@gmail.com', 'Admin');
            $message->subject('Your CareGuide account has been created.');
            $message->to('imchosen6@gmail.com');
        });

        return redirect('volunteers')->with('success', 'Volunteers is added successfully!');
    }

    public function edit($id)
    {
        $validator = JsValidator::formRequest('App\Http\Requests\VolunteerRequest');

        $volunteer = Volunteer::findOrFail($id);
        $genderList = ['M'=> 'Male', 'F' => 'Female'];

        return view('volunteers.edit', compact('validator', 'volunteer', 'genderList'));
    }

    public function update($id, VolunteerRequest $request)
    {
        $volunteer = Volunteer::findOrFail($id);

        $volunteer->update([
            'nric'      => $request->get('nric'),
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

        return back()->with('success', 'Volunteer is updated successfully!');
    }

    public function rejectVolunteer($id) {
        $volunteer = Volunteer::findOrFail($id);

        if($volunteer->is_approved) {
            $volunteer->is_approved = false;
            $volunteer->save();
        }

        return back()->with('success', 'Volunteer is rejected!');
    }

    public function approveVolunteer($id) {
        $volunteer = Volunteer::findOrFail($id);

        if( ! $volunteer->is_approved) {
            $volunteer->is_approved = true;
            $volunteer->save();
        }

        return back()->with('success', 'Volunteer is approved!');
    }
}