<?php

namespace App\Http\Controllers\Ranks;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Rank;
use Auth;
use Hash;
use Validator;

class RankController extends Controller
{
    public function index()
    {
        $ranks = Rank::all();

        return view('ranks.manage', compact('ranks'));
    }
}
