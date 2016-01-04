<?php

namespace App\Http\Controllers\Elderly;

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

class ElderlyController extends Controller
{
    public function index()
    {
        $elderlyInCentres = Elderly::with('languages')->ofCentreForStaff(Auth::user())->get();

        return view('elderly.index', compact('elderlyInCentres'));
    }

    public function show($id)
    {
        $activity = Activity::with('volunteers')->findOrFail($id);

        return view('activities.show', compact('activity'));
    }

    public function create()
    {
        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');
        $genderList = ['M'=> 'M', 'F' => 'F'];
        $languages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        return view('elderly.create', compact('centreList', 'genderList', 'languages'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'centre'            => 'required|string',
            'nric'              => 'required|string|unique:elderly,nric,null,elderly_id',
            'name'              => 'required|string',
            'gender'            => 'required|in:M,F',
            'photo'             => 'image',
            'languages'         => 'required|array',
            'nok_name'          => 'required|string',
            'nok_contact'       => 'required|digits:8',
            'medical_condition' => 'string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $elderly = Elderly::create([
                'nric'                  => $request->get('nric'),
                'name'                  => $request->get('name'),
                'gender'                => $request->get('gender'),
                'next_of_kin_name'      => $request->get('nok_name'),
                'next_of_kin_contact'   => $request->get('nok_contact'),
                'medical_condition'     => $request->get('medical_condition'),
                'image_photo'           => $request->get('photo'),
                'centre_id'             => $request->get('centre'),
            ]);

            foreach($request->get('languages') as $language) {
                ElderlyLanguage::create([
                    'elderly_id'    => $elderly->elderly_id,
                    'language'      => $language,
                ]);
            }

            return back()->with('success', 'Senior added successfully!');
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
}
