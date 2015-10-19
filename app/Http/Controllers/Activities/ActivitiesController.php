<?php

namespace App\Http\Controllers\Activities;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Activity;
use Auth;
use Hash;
use Validator;

class ActivitiesController extends Controller
{
    public function index() {
        return 'HAHA';
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

    public function store()
    {

    }
}
