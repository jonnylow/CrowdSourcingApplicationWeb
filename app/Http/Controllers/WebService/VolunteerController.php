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
use App\Rank;
use Carbon\Carbon;
use Mail;



class VolunteerController extends Controller
{
    public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['addUserAccount','checkEmail','checkNRIC','retrieveUserAccounts','retrieveUserDetails','verifyUserEmailandPassword']]);
   }

   public function addUserAccount(Request $request ){
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
                'rank_id'                   => Rank::where('min','0')->rank_id->get(),
                'is_approved'               => 'False']);
        //}
    $check = $request->get('email');
    $email = Volunteer::where('email',$check)->get();
    //return response()->json(compact('email'));

    if ($email->isEmpty()){
      $status = array("error");
      return response()->json(compact('status'));
    } else {
      $status = array("Created successfully");
      return response()->json(compact('status'));
    }

        
   }
// tested working with new database 
   public function checkEmail(Request $request){
    $check = $request->get('email');
    //check if email exist in database - do not exist for no / exist for yes
    $email = Volunteer::where('email',$check)->get();
    //return response()->json(compact('email'));

    if ($email->isEmpty()){
      $status = array("do not exist");
      return response()->json(compact('status'));
    } else {
      $status = array("exist");
      return response()->json(compact('status'));
    }
    
   }

// tested working with new database 
   public function checkNRIC(Request $request){
    $check = $request->get('nric');
    //check if email exist in database - do not exist for no / exist for yes
    $nric = Volunteer::where('nric',$check)->get();
    //return response()->json(compact('nric'));

    if ($nric->isEmpty()){
      $status = array("do not exist");
      return response()->json(compact('status'));
    } else {
      $status = array("exist");
      return response()->json(compact('status'));
    }
   }

   /*public function retrieveUserAccounts(Request $request){
    // retrieve volunetter id, name , email, isapproved
    $check = $request->get('email');
    //check if email exist in database - do not exist for no / exist for yes
    $user = Volunteer::where('email',$check)->get();
    //return response()->json(compact('user'));
    $vid=$user->volunteer_id;
    $name=$user->name;
    $email=$user->email;
    $approval=$user->is_approved;
    $return=array($vid,$name,$email,$approval);

    if ($email->isEmpty()){
      $status = array("do not exist");
      return response()->json(compact('status'));
    } else {
      return response()->json(compact('return'));
    }

   }*/
// tested working with new database 
   public function retrieveUserDetails(Request $request){
    // retrieve all details based on volunteer id
    $id = $request->get('id');
    $volunteer = Volunteer::findOrFail($id);
    return response()->json(compact('volunteer'));
   }

   public function verifyUserEmailandPassword(Request $request){
      if ($request->has('email') && $request->has('phone') ) {
        $email = $request->get('email');
          $phone = $request->get('phone');
          $volunteer = Volunteer::where('email', $email)->where('contact_no',$phone)->first();
          if ($volunteer){
            $password = str_random(12);
            $message = "Hi " . $volunteer->name .", \r\n \r\n Your temporary password is " . $password . ". Please Login and change your password immiediately! \r\n If you did not request for this password change, please contact us at xxx@xxx.xx. \r\n This is a system generated email";
            
            Mail::raw($message, function($message) {
            $message->from('imchosen6@gmail.com', 'Admin');
            $message->subject('CareRide Password Reset');
            $message->to('lychiang.2013@sis.smu.edu.sg');
            });
            $volunteer->password = $password;
            $volunteer->save();
            $status = array("success");
            return response()->json(compact('status'));
            } else {
            $status = array("mismatch");
            return response()->json(compact('status'));
          }
        } else {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
          


        }
   }
}


