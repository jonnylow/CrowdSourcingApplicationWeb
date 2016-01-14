<?php

namespace App\Http\Controllers\Volunteers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Volunteer;
use Auth;
use Validator;

class VolunteersController extends Controller
{
    public function index()
    {
        $volunteers = Volunteer::all();

        return view('volunteers.index', compact('volunteers'));
    }
}
