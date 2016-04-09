<?php

namespace App\Http\Controllers\Elderly;

use Illuminate\Http\Request;

use App\Http\Requests\CreateElderlyRequest;
use App\Http\Requests\EditElderlyRequest;
use App\Http\Controllers\Controller;
use App\Centre;
use App\Elderly;
use App\ElderlyLanguage;
use Auth;
use JsValidator;

class ElderlyController extends Controller
{
    public function __construct()
    {
        // Apply the elderly.centre middleware to only show, edit, update and destroy methods.
        // We only allow admin, or regular staff from the same centre, to access them.
        $this->middleware('elderly.centre', ['only' => ['show', 'edit', 'update', 'destroy']]);
    }

    public function index()
    {
        if (Auth::user()->is_admin)
            $elderlyInCentres = Elderly::with('languages')->get();
        else
            $elderlyInCentres = Elderly::with('languages')->ofCentreForStaff(Auth::user())->get();

        return view('elderly.index', compact('elderlyInCentres'));
    }

    public function show($id)
    {
        $elderly = Elderly::with('activities', 'languages')->findOrFail($id);

        return view('elderly.show', compact('elderly'));
    }

    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\CreateElderlyRequest');

        $genderList = ['M' => 'Male', 'F' => 'Female'];
        $languages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        if (Auth::user()->is_admin)
            $centreList = Centre::all()->lists('name', 'centre_id')->sort();
        else
            $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id')->sort();

        if(is_array(old('languages'))) {
            foreach (old('languages') as $l) {
                $languages[$l] = $l;
            }
        }

        return view('elderly.create', compact('validator', 'centreList', 'genderList', 'languages'));
    }

    public function store(CreateElderlyRequest $request)
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
        $validator = JsValidator::formRequest('App\Http\Requests\EditElderlyRequest');

        $elderly = Elderly::findOrFail($id);
        $genderList = ['M' => 'Male', 'F' => 'Female'];
        $languages = ElderlyLanguage::distinct()->lists('language', 'language')->sort();

        if (Auth::user()->is_admin)
            $centreList = Centre::all()->lists('name', 'centre_id')->sort();
        else
            $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id')->sort();

        if(is_array(old('languages'))) {
            foreach (old('languages') as $l) {
                $languages[$l] = $l;
            }
        }

        return view('elderly.edit', compact('validator', 'elderly', 'centreList', 'genderList', 'languages'));
    }

    public function update($id, EditElderlyRequest $request)
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
        ]);

        // Gets the languages that are currently in the database
        $currentLanguages = $elderly->languages->lists('language', 'language');

        // Adds any new languages into the database
        foreach($request->get('languages') as $language) {
            if($currentLanguages->has($language)) {
                $currentLanguages->forget($language);
            } else {
                ElderlyLanguage::create([
                    'elderly_id' => $elderly->elderly_id,
                    'language' => $language,
                ]);
            }
        }

        // Remove any current languages that are not in the $request
        foreach ($currentLanguages as $language) {
            ElderlyLanguage::where('elderly_id', $id)
                ->where('language', $language)
                ->delete();
        }

        return redirect()->route('elderly.show', compact('elderly'))->with('success', 'Senior is updated successfully!');
    }

    public function destroy($id)
    {
        $elderly = Elderly::findOrFail($id);
        $elderly->delete();

        return back()->with('success', 'Senior is removed successfully!');
    }
}
