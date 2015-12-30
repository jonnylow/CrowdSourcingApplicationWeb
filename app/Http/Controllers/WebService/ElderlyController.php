<?php

namespace App\Http\Controllers\WebService;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Config;
use App\Activity;
use App\Task;
use App\Volunteer;
use App\Elderly;
use Carbon\Carbon;



class ElderlyController extends Controller
{
    public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['retrieveElderyInformation']]);
   }

   public function retrieveElderyInformation(Request $request){
        $userID = $request->get('id');
        $actID = $request->get('transportId');
        $activity = Activity::findOrFail($actID);
        $elderlyID = $activity->elderly_id;
        //return response()->json(compact('elderlyID'));
        $elderly = Elderly::findOrFail($elderlyID);

        if ($elderly==null){
        $status = array("error");
        return response()->json(compact('status'));
      } else {
        return response()->json(compact('elderly'));
      }

   }

   
}


