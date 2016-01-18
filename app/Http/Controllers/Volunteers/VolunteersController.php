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
}
