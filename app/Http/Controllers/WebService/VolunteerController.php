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
        // Set the Eloquent model that should be used to retrieve your users
        Config::set('auth.model', 'App\Volunteer');

        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        Config::set('auth.model', 'App\Volunteer');
        $this->middleware('jwt.auth', ['except' => ['addUserAccount', 'checkEmail', 'checkNRIC', 'retrieveUserAccounts', 'retrieveUserDetails', 'verifyUserEmailandPassword', 'updateUserAccount', 'updateUserDetails', 'retrieveMyTransportActivityDetails', 'retrieveRankingDetails', 'getAllVolunteerContribution']]);
    }

    public function addUserAccount(Request $request)
    {
        Volunteer::create([
            'nric' => $request->get('nric'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'gender' => $request->get('gender'),
            'date_of_birth' => $request->get('dob'),
            'contact_no' => $request->get('phone'),
            'occupation' => $request->get('occupation'),
            'has_car' => $request->get('haveCar'),
            'minutes_volunteered' => '0',
            'area_of_preference_1' => $request->get('preferences1'),
            'area_of_preference_2' => $request->get('preferences2'),
            'image_nric_front' => $request->get('frontIC'),
            'image_nric_back' => $request->get('backIC'),
            'rank_id' => Rank::where('min', 0)->first()->rank_id,
        ]);

        $volunteer = Volunteer::where('email', $request->get('email'))->first();

        if ($volunteer->isEmpty()) {
            $status = array("error");
            return response()->json(compact('status'));
        } else {
            Mail::send('emails.volunteer_registration', compact('volunteer'), function ($message) {
                $message->from('imchosen6@gmail.com', 'CareGuide Account Registration');
                $message->subject('A CareGuide Volunteer account has been registered and awaiting Approval.');
                $message->to('imchosen6@gmail.com');
            });
            $status = array("Created successfully");
            return response()->json(compact('status'));
        }
    }

// tested working with new database
    public function checkEmail(Request $request)
    {
        $check = $request->get('email');
        //check if email exist in database - do not exist for no / exist for yes
        $email = Volunteer::where('email', $check)->get();
        //return response()->json(compact('email'));

        if ($email->isEmpty()) {
            $status = array("do not exist");
            return response()->json(compact('status'));
        } else {
            $status = array("exist");
            return response()->json(compact('status'));
        }

    }

// tested working with new database
    public function checkNRIC(Request $request)
    {
        $check = $request->get('nric');
        //check if email exist in database - do not exist for no / exist for yes
        $nric = Volunteer::where('nric', $check)->get();
        //return response()->json(compact('nric'));

        if ($nric->isEmpty()) {
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
    public function retrieveUserDetails(Request $request)
    {
        // retrieve all details based on volunteer id
        $id = $request->get('id');
        $volunteer = Volunteer::with('rank')->where('volunteer_id', '=', $id)->get();
        $volunteerHours = Volunteer::findOrFail($id)->timeVolunteered();

        //$volunteer = Volunteer::with('rank')->where('volunteer_id','=',$id)->timeVolunteered()->get()->toArray();
        //array_set($volunteerArray, 'volunteer.minutes_volunteered', $volunteerHours);

        $volunteerRank = Volunteer::findOrFail($id)->rank_id;
        $volunteerRank = $volunteerRank - 1;
        if ($volunteerRank > 1) {
            $nextRank = Rank::findOrFail($volunteerRank);
        } else {
            $nextRank = '';
        }
        return response()->json(compact('volunteer', 'volunteerHours', 'nextRank'));
    }

    public function verifyUserEmailandPassword(Request $request)
    {
        if ($request->has('email') && $request->has('phone')) {
            $email = $request->get('email');
            $phone = $request->get('phone');
            $volunteer = Volunteer::where('email', $email)->where('contact_no', $phone)->first();
            if ($volunteer->isEmpty()) {
                $status = array("error");
                return response()->json(compact('status'));
            } else {
                $password = str_random(12);

                Mail::send('emails.mobile_password', compact('volunteer', 'password'), function ($message) {
                    $message->from('imchosen6@gmail.com', 'CareGuide Password Management');
                    $message->subject('Your request for your CareGuide account password Reset.');
                    $message->to('imchosen6@gmail.com');
                });

                $volunteer->password = $password;
                $volunteer->save();
                $status = array("success");
                return response()->json(compact('status'));
            }
        } else {
            $status = array("error");
            return response()->json(compact('status'));
        }
    }

    public function updateUserAccount(Request $request)
    {
        if ($request->get('id') == null || $request->get('password') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $volunteer_id = $request->get('id');
            $password = $request->get('password');

            $volunteer = Volunteer::findOrFail($volunteer_id);

            if ($volunteer->isEmpty()) {
                $status = array("error");
                return response()->json(compact('status'));
            } else {
                Mail::send('emails.mobile_password_reset', compact('volunteer'), function ($message) {
                    $message->from('imchosen6@gmail.com', 'CareGuide Password Management');
                    $message->subject('Your CareGuide account password was recently changed.');
                    $message->to('imchosen6@gmail.com');
                });

                $volunteer->password = $password;
                $volunteer->save();
                $status = array("success");
                return response()->json(compact('status'));
            }
        }
    }

    public function updateUserDetails(Request $request)
    {
        if ($request->get('id') == null || $request->get('name') == null || $request->get('email') == null || $request->get('dob') == null|| $request->get('gender') == null || $request->get('hasCar') == null || $request->get('occupation') == null || $request->get('p1') ==null || $request->get('p2') == null) {

            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $volunteer_id = $request->get('id');
            $name = $request->get('name');
            $email = $request->get('email');
            $dob = $request->get('dob');
            $gender = $request->get('gender');
            $hasCar = $request->get('hasCar');
            $occupation = $request->get('occupation');
            $p1 = $request->get('p1');
            $p2 = $request->get('p2');

            $volunteer = Volunteer::findOrFail($volunteer_id);

            if ($volunteer->isEmpty()) {
                $status = array("Error in sql statement");
                return response()->json(compact('status'));
            } else {
                Mail::send('emails.mobile_account_update', compact('volunteer'), function ($message) {
                    $message->from('imchosen6@gmail.com', 'CareGuide Account Management');
                    $message->subject('Your CareGuide account particulars was recently updated.');
                    $message->to('imchosen6@gmail.com');
                });

                $volunteer->email = $email;
                $volunteer->name = $name;
                $volunteer->date_of_birth = $dob;
                $volunteer->gender = $gender;
                $volunteer->has_car = $hasCar;
                $volunteer->occupation = $occupation;
                $volunteer->area_of_preference_1 = $p1;
                $volunteer->area_of_preference_2 = $p2;
                $volunteer->save();
                $status = array("Update Success!");
                return response()->json(compact('status'));
            }
        }
    }

    public function retrieveMyTransportActivityDetails(Request $request)
    {
        if ($request->get('id') == null || $request->get('transportId') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $id = $request->get('id');
            $transportId = $request->get('transportId');

            $activities = Activity::with('departureCentre', 'arrivalCentre')->where('activity_id', '=', $transportId)->get();
            $task = Task::where('volunteer_id', '=', $id)->where('activity_id', '=', $transportId)->get();
            return response()->json(compact('activities', 'task'));
        }
    }

    public function retrieveRankingDetails(Request $request)
    {
        if ($request->get('id') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $volunteer_id = $request->get('id');
            $volunteer = Volunteer::findOrFail($volunteer_id);
            $minutesVolunteered = $volunteer->minutes_volunteered;
            $completed = Task::where('volunteer_id', '=', $volunteer_id)->where('status', '=', 'completed')->count();
            $withdrawn = Task::where('volunteer_id', '=', $volunteer_id)->where('approval', '=', 'withdrawn')->count();

            return response()->json(compact('volunteer_id', 'minutesVolunteered', 'completed', 'withdrawn'));

        }

    }

    public function graphInformation(Request $request){
      if ($request->get('token') != null){
          $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
          $id = $authenticatedUser->volunteer_id;
          //$today = Carbon::now();
          //$dateFourMonths = Carbon::today()->subMonths(4)->toDateTimeString();
          //$dateThreeMonths = Carbon::today()->subMonths(3)->toDateTimeString();
          //$dateTwoMonths = Carbon::today()->subMonths(2)->toDateTimeString();
          //$dateOneMonths = (new Carbon('first day of this month'))->toDateTimeString();
          //$dateToday = $today->toDateTimeString();

          // four months
          $activitiesWithinFrame = Activity::completed()->subMonth(3)->lists('activities.activity_id');
          $fourMonthsUserList = Task::whereIn('activity_id',$activitiesWithinFrame)->where('volunteer_id',$id)->where('status','completed')->lists('activity_id');

          if ($fourMonthsUserList->isEmpty()){
            $fourMonthsAgo = 0;
          } else {
            $fourMonthsAgo = Activity::whereIn('activity_id',$fourMonthsUserList)->sum('expected_duration_minutes');
          }
          // three months
          $activitiesWithinFrame = Activity::completed()->subMonth(2)->lists('activities.activity_id');
          $threeMonthsUserList = Task::whereIn('activity_id',$activitiesWithinFrame)->where('volunteer_id',$id)->where('status','completed')->lists('activity_id');

          if ($threeMonthsUserList->isEmpty()){
            $threeMonthsAgo = 0;
          } else {
            $threeMonthsAgo = Activity::whereIn('activity_id',$threeMonthsUserList)->sum('expected_duration_minutes');
          }

          // two months
          $activitiesWithinFrame = Activity::completed()->subMonth(1)->lists('activities.activity_id');
          $twoMonthsUserList = Task::whereIn('activity_id',$activitiesWithinFrame)->where('volunteer_id',$id)->where('status','completed')->lists('activity_id');

          if ($twoMonthsUserList->isEmpty()){
            $twoMonthsAgo = 0;
          } else {
            $twoMonthsAgo = Activity::whereIn('activity_id',$twoMonthsUserList)->sum('expected_duration_minutes');
          }

          // one months

          $activitiesWithinFrame = Activity::completed()->subMonth(0)->lists('activities.activity_id');
          $oneMonthsUserList = Task::whereIn('activity_id',$activitiesWithinFrame)->where('volunteer_id',$id)->where('status','completed')->lists('activity_id');

          if ($oneMonthsUserList->isEmpty()){
            $oneMonthAgo = 0;
          } else {
            $oneMonthAgo = Activity::whereIn('activity_id',$oneMonthsUserList)->sum('expected_duration_minutes');
          }

          $rankid = Volunteer::where('volunteer_id',$id)->value('rank_id');
          $rank = Rank::findOrFail($rankid)->name;

          $taskUserDone = Task::where('volunteer_id',$id)->where('status','completed')->lists('activity_id');
          $totalHours = Activity::whereIn('activity_id',$taskUserDone)->sum('expected_duration_minutes');


          return response()->json(compact('fourMonthsAgo','threeMonthsAgo','twoMonthsAgo','oneMonthAgo','rank','totalHours'));

      } else {
        $status = array("Missing parameter");
        return response()->json(compact('status'));
      }
    }

    public function getAllVolunteerContribution(){
        $totalVolunteers = Volunteer::where('is_approved','approved')->count('volunteer_id');

        $totalTaskList = Task::where('status','completed')->lists('activity_id');
        $totalTaskHours = Activity::whereIn('activity_id',$totalTaskList)->sum('expected_duration_minutes');

        return response()->json(compact('totalVolunteers','totalTaskHours'));
      }

    public function volunteerLeaderboard(Request $request) {
      if ($request->get('token') != null){
          $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
          $id = $authenticatedUser->volunteer_id;
          // user rank
          $rankid = Volunteer::where('volunteer_id',$id)->value('rank_id');
          $rank = Rank::findOrFail($rankid)->name;
          // User Minutes Completed
          $taskUserDone = Task::where('volunteer_id',$id)->where('status','completed')->lists('activity_id');
          $totalHours = Activity::whereIn('activity_id',$taskUserDone)->sum('expected_duration_minutes');
          // top 10 volunteers
          $volunteersList = Volunteer::orderBy('minutes_volunteered','desc')->lists('name','minutes_volunteered');

          return response()->json(compact('rank','totalHours','volunteersList'));

      } else {
          $status = array("Missing parameter");
          return response()->json(compact('status'));
      }
    }
}


