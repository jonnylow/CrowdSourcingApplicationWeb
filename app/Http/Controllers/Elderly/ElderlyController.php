<?php

namespace App\Http\Controllers\Elderly;

use Illuminate\Http\Request;

use App\Http\Requests\ElderlyRequest;
use App\Http\Controllers\Controller;
use App\Elderly;
use App\ElderlyLanguage;
use Auth;
use JsValidator;

class ElderlyController extends Controller
{
    public function index()
    {
        $elderlyInCentres = Elderly::with('languages')->ofCentreForStaff(Auth::user())->get();

        return view('elderly.index', compact('elderlyInCentres'));
    }

    public function show($id)
    {
        $elderly = Elderly::with('languages')->findOrFail($id);

        return view('elderly.show', compact('elderly'));
    }

    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\ElderlyRequest');

        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');
        $genderList = ['M'=> 'Male', 'F' => 'Female'];
        $languages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        if(is_array(old('languages'))) {
            foreach (old('languages') as $l) {
                $languages[$l] = $l;
            }
        }

        return view('elderly.create', compact('validator', 'centreList', 'genderList', 'languages'));
    }

    public function store(ElderlyRequest $request)
    {
        $elderly = Elderly::create([
            'centre_id'             => $request->get('centre'),
            'nric'                  => $request->get('nric'),
            'name'                  => $request->get('name'),
            'gender'                => $request->get('gender'),
            'birth_year'            => $request->get('birth_year'),
            'next_of_kin_name'      => $request->get('nok_name'),
            'next_of_kin_contact'   => $request->get('nok_contact'),
            'medical_condition'     => $request->get('medical_condition'),
            'image_photo'           => $request->file('photo'),
        ]);

        foreach($request->get('languages') as $language) {
            ElderlyLanguage::create([
                'elderly_id'    => $elderly->elderly_id,
                'language'      => $language,
            ]);
        }

        return redirect('elderly')->with('success', 'Senior is added successfully!');
    }

    public function edit($id)
    {
        $validator = JsValidator::formRequest('App\Http\Requests\ElderlyRequest');

        $elderly = Elderly::findOrFail($id);
        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');
        $genderList = ['M'=> 'Male', 'F' => 'Female'];
        $languages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        if(is_array(old('languages'))) {
            foreach (old('languages') as $l) {
                $languages[$l] = $l;
            }
        }

        return view('elderly.edit', compact('validator', 'elderly', 'centreList', 'genderList', 'languages'));
    }

    public function update($id, ElderlyRequest $request)
    {
        $elderly = Elderly::findOrFail($id);

        $elderly->update([
            'centre_id'             => $request->get('centre'),
            'nric'                  => $request->get('nric'),
            'name'                  => $request->get('name'),
            'gender'                => $request->get('gender'),
            'birth_year'            => $request->get('birth_year'),
            'next_of_kin_name'      => $request->get('nok_name'),
            'next_of_kin_contact'   => $request->get('nok_contact'),
            'medical_condition'     => $request->get('medical_condition'),
            'image_photo'           => $request->file('photo'),
        ]);

        foreach($request->get('languages') as $language) {
            ElderlyLanguage::create([
                'elderly_id'    => $elderly->elderly_id,
                'language'      => $language,
            ]);
        }

        return back()->with('success', 'Senior is updated successfully!');
    }

    public function destroy($id)
    {
        $elderly = Elderly::findOrFail($id);
        $elderly->delete();

        return back()->with('success', 'Senior is removed successfully!');
    }
}
