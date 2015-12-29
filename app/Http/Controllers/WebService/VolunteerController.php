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
use Carbon\Carbon;



class VolunteerController extends Controller
{
    public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['AddUserAccount','CheckEmail']]);
   }

   public function AddUserAccount(Request $request ){
      /*$validator = Validator::make($request->all(), [
            'nric'                    => 'required|string',
            'name'                    => 'required|string',
            'date_of_birth'           => 'required|date|after:today',
            'email'                   => 'required|string',
            'password'                => 'required|string',
            'gender'                  => 'required',
            'contact_no'              => 'required|string',
            'occupation'              => 'required|string',
            'has_car'                 => 'required|string',
            'minutes_volunteered'     => 'required|string',
            'area_of_preference_1'    => 'required|string',
            'area_of_preference_2'    => 'required|string',
            'image_nric_front'        => 'required|string',
            'image_nric_back'         => 'required|string',
            'is_approved'             => 'required|string',

        ]);
      if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {*/
          Volunteer::create([
                'nric'                      => $request->get('nric'),
                'name'                      => $request->get('name'),
                'email'                     => $request->get('email'),
                'password'                  => $request->get('password'),
                'gender'                    => $request->get('gender'),
                'date_of_birth'             => $request->get('dob'),
                'contact_no'                => $request->get('phone'),
                'occupation'                => $request->get('occupation'),
                'has_car'                   => $request->get('haveCar'),
                'minutes_volunteered'       => '0',
                'area_of_preference_1'      => $request->get('preferences1'),
                'area_of_preference_2'      => $request->get('preferences2'),
                'image_nric_front'          => $request->get('frontIC'),
                'image_nric_back'           => $request->get('backIC'),
                'is_approved'               => 'False']);
        //}
        return back()->with('success', 'Created successfully');

        
   }

   public function CheckEmail(Request $request){
    $check = $request->get('email');
    //check if email exist in database - do not exist for no / exist for yes
    $email = Volunteer::findOrFail($check);
    return response()->json(compact('email'));
   }

   public function CheckNRIC(Request $request){
    $check = $request->get('nric');
    //check if email exist in database - do not exist for no / exist for yes
   }

   public function RetrieveUserAccounts(Request $request){
    // retrieve volunetter id, name , email, isapproved
   }

   public function RetrieveUserDetails(Request $request){
    // retrieve all details based on volunteer id
   }
}


