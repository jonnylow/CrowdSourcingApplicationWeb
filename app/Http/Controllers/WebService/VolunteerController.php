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
use App\Staff;
use Carbon\Carbon;
use Mail;
use TransmitSMS;


class VolunteerController extends Controller
{
    /**
     * Instantiate a new VolunteerController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Set the Eloquent model that should be used to retrieve your users
        Config::set('auth.model', 'App\Volunteer');

        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        Config::set('auth.model', 'App\Volunteer');
        $this->middleware('jwt.auth', ['except' => ['sendSMS', 'addUserAccount', 'checkEmail', 'checkNRIC', 'retrieveUserAccounts', 'retrieveUserDetails', 'verifyUserEmailandPassword', 'updateUserAccount', 'updateUserDetails', 'retrieveMyTransportActivityDetails', 'retrieveRankingDetails', 'getAllVolunteerContribution','sendFeedback']]);
    }

    /**
     * Retrieves all activities that are available, if authenticated, checks for user applied activities.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of status
     */
    public function sendSMS(Request $request)
    {
        $result = TransmitSMS::sendSms($request->get('message'), $request->get('number'), 'CareGuide');

        if($result->error->code=='SUCCESS') {
            $json['status'] = "sent";
            return response()->json($json);
        } else {
            $json['status'] = "not sent";
            $json['error'] = $result->error->code;
            return response()->json($json);
        }
    }

    /**
     * Handles registration process of new volunteer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of status
     */
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

        $mailingList = Staff::where('is_admin','TRUE')->lists('email')->toArray();

        if ($volunteer==null) {
            $status = array("error");
            return response()->json(compact('status'));
        } else {
            Mail::send('emails.volunteer_registration', compact('volunteer'),function ($message) use ($mailingList){
                $message->subject('New Volunteer Registration');
                $message->bcc($mailingList);
            });
            $status = array("Created successfully");
            return response()->json(compact('status'));
        }
    }

    /**
     * Check if email has been used.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of status
     */
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

    /**
     * Checks if the NRIC has been used.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of status
     */
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

    /**
     * Retrieves the user information based on volunteer ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of Volunteer information
     */
    public function retrieveUserDetails(Request $request)
    {
        // retrieve all details based on volunteer id
        $id = $request->get('id');
        $volunteer = Volunteer::with('rank')->where('volunteer_id', '=', $id)->get();
        $volunteerHours = Volunteer::findOrFail($id)->timeVolunteered();


        $volunteerRank = Volunteer::findOrFail($id)->rank_id;
        $volunteerRank = $volunteerRank - 1;
        if ($volunteerRank > 1) {
            $nextRank = Rank::findOrFail($volunteerRank);
        } else {
            $nextRank = '';
        }
        return response()->json(compact('volunteer', 'volunteerHours', 'nextRank'));
    }

    /**
     * Handles the password reset request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of status
     */
    public function verifyUserEmailandPassword(Request $request)
    {
        if ($request->has('email') && $request->has('phone')) {
            $email = $request->get('email');
            $phone = $request->get('phone');
            $volunteer = Volunteer::where('email', $email)->where('contact_no', $phone)->first();
            if ($volunteer==null) {
                $status = array("error");
                return response()->json(compact('status'));
            } else {
                $password = str_random(12);

                Mail::send('emails.mobile_password', compact('volunteer', 'password'), function ($message) use ($volunteer) {
                    $message->subject('Your request for your CareGuide account password Reset.');
                    $message->bcc($volunteer->email,$volunteer->name);
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

    /**
     * Handles password changes for user account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of status
     */
    public function updateUserAccount(Request $request)
    {
        if ($request->get('id') == null || $request->get('password') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $volunteer_id = $request->get('id');
            $password = $request->get('password');

            $volunteer = Volunteer::find($volunteer_id);

            if ($volunteer==null) {
                $status = array("error");
                return response()->json(compact('status'));
            } else {
                Mail::send('emails.mobile_password_reset', compact('volunteer'), function ($message) use ($volunteer) {
                    $message->subject('Your CareGuide account password was recently changed.');
                    $message->to($volunteer->email,$volunteer->name);
                });

                $volunteer->password = $password;
                $volunteer->save();
                $status = array("success");
                return response()->json(compact('status'));
            }
        }
    }

    /**
     * Handles information changes for user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of status
     */
    public function updateUserDetails(Request $request)
    {
       
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

            if ($volunteer==null) {
                $status = array("Error in sql statement");
                return response()->json(compact('status'));
            } else {
              $volunteer->update([
                'name'     =>$name ,
                'email'     => $email,
                'gender'  => $gender,
                'date_of_birth'  => $dob,
                'occupation'  => $occupation,
                'has_car'  => $request->get('hasCar'),
                'area_of_preference_1'  => $p1,
                'area_of_preference_2'  => $p2,
                ]);
                $status = array("Update Success!");
                
                Mail::send('emails.mobile_account_update', compact('volunteer'), function ($message) use ($volunteer) {
                    $message->subject('Your CareGuide account particulars was recently updated.');
                    $message->bcc($volunteer->email,$volunteer->name);
                });

                

                return response()->json(compact('status'));
            }
        
    }

    /**
     * Retrieves activities based on user and activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of status
     */
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

    /**
     * Retrieves ranking of the user based on user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array status
     */
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

    /**
     * Retrieves statistics of user activity for past months for user dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array with each month's hours and total hours and rank
     */
    public function graphInformation(Request $request){
      if ($request->get('token') != null){
          $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
          $id = $authenticatedUser->volunteer_id;
          $volunteer = Volunteer::findOrFail($id);

          // four months
          $activitiesWithinFrame = Activity::completed()->subMonth(3)->lists('activities.activity_id');
          $fourMonthsUserList = Task::whereIn('activity_id',$activitiesWithinFrame)->where('volunteer_id',$id)->where('status','completed')->lists('activity_id');

          if ($fourMonthsUserList->isEmpty()){
            $fourMonthsAgo = 0;
          } else {
            $fourMonthsAgo = Activity::whereIn('activity_id',$fourMonthsUserList)->sum('expected_duration_minutes');
            $fourMonthsAgo = floor($fourMonthsAgo/60);
          }
          // three months
          $activitiesWithinFrame = Activity::completed()->subMonth(2)->lists('activities.activity_id');
          $threeMonthsUserList = Task::whereIn('activity_id',$activitiesWithinFrame)->where('volunteer_id',$id)->where('status','completed')->lists('activity_id');

          if ($threeMonthsUserList->isEmpty()){
            $threeMonthsAgo = 0;
          } else {
            $threeMonthsAgo = Activity::whereIn('activity_id',$threeMonthsUserList)->sum('expected_duration_minutes');
            $threeMonthsAgo = floor($threeMonthsAgo/60);
          }

          // two months
          $activitiesWithinFrame = Activity::completed()->subMonth(1)->lists('activities.activity_id');
          $twoMonthsUserList = Task::whereIn('activity_id',$activitiesWithinFrame)->where('volunteer_id',$id)->where('status','completed')->lists('activity_id');

          if ($twoMonthsUserList->isEmpty()){
            $twoMonthsAgo = 0;
          } else {
            $twoMonthsAgo = Activity::whereIn('activity_id',$twoMonthsUserList)->sum('expected_duration_minutes');

            $twoMonthsAgo = floor($twoMonthsAgo/60);
          }

          // one months

          $activitiesWithinFrame = Activity::completed()->subMonth(0)->lists('activities.activity_id');
          $oneMonthsUserList = Task::whereIn('activity_id',$activitiesWithinFrame)->where('volunteer_id',$id)->where('status','completed')->lists('activity_id');

          if ($oneMonthsUserList->isEmpty()){
            $oneMonthAgo = 0;
          } else {
            $oneMonthAgo = Activity::whereIn('activity_id',$oneMonthsUserList)->sum('expected_duration_minutes');
            $oneMonthAgo = floor($oneMonthAgo/60);
          }

          $rankid = Volunteer::where('volunteer_id',$id)->value('rank_id');
          $rank = Rank::findOrFail($rankid)->name;

          $totalHours = $volunteer->minutes_volunteered;
          $totalHours = floor($totalHours/60);


          return response()->json(compact('fourMonthsAgo','threeMonthsAgo','twoMonthsAgo','oneMonthAgo','rank','totalHours'));

      } else {
        $status = array("Missing parameter");
        return response()->json(compact('status'));
      }
    }

    /**
     * Retrieves total amount of volunteered hours for non-authenticated dashboard.
     * 
     * @return  JSON  array with total volunteers and total hours
     */
    public function getAllVolunteerContribution(){
        $totalVolunteers = Volunteer::where('is_approved','approved')->count('volunteer_id');

        $totalTaskHours = Volunteer::sum('minutes_volunteered');

        $totalTaskHours =floor($totalTaskHours/60);
        return response()->json(compact('totalVolunteers','totalTaskHours'));
      }

    /**
     * Retrieves information for volunteer leaderboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array with top 10 users and position
     */
    public function volunteerLeaderboard(Request $request) {
      if ($request->get('token') != null){
          $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
          $id = $authenticatedUser->volunteer_id;
          $volunteerEnquired = Volunteer::findOrFail($id);
          $volunteerName = $volunteerEnquired->name;
          // user rank
          $rankid = Volunteer::where('volunteer_id',$id)->value('rank_id');
          $rank = Rank::findOrFail($rankid)->name;
          $totalMinutes = Volunteer::where('volunteer_id',$id)->value('minutes_volunteered');

          $volunteerIdList = Volunteer::where('is_approved','approved')->orderBy('minutes_volunteered','desc')->lists('volunteer_id');
          $count = 0;
          $xCount = 1;
          $pos = 0;
          $returnArray = [];
          $listSize =  count($volunteerIdList)-1 ;
          do  {
            $volunteerID = $volunteerIdList[$count];
            $volunteer = Volunteer::find($volunteerID);
            $volunteerName = $volunteer->name;
            $volunteerMinutes = $volunteer->minutes_volunteered;
            $stringToAdd = $volunteerMinutes . "," . $volunteerName . "," . $xCount ;
            $returnArray[] =  $stringToAdd;
            if ($id == $volunteerID){
                $pos = $xCount;
              }
            $count = $count +1;
            $xCount = $xCount + 1;
          } while ($count <= $listSize );

          return response()->json(compact('rank','totalMinutes','returnArray','pos'));

      } else {
          $status = array("Missing parameter");
          return response()->json(compact('status'));
      }
    }

    /**
     * Retrieves information for volunteer's activity of the day.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of activity
     */
    public function todayActivity(Request $request){
      if ($request->get('token') != null){
          // Get Authenticated User
          $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
          $id = $authenticatedUser->volunteer_id;
          // Retrieve Activties within today
          $todayactivities = Activity::whereBetween('datetime_start',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->lists('activity_id');
          // Retrieve Related Activties within today related to volunteer
          $relatedActivty = Task::whereIn('activity_id',$todayactivities)->where('volunteer_id',$id)->where('approval','approved')->where('status','new task')->lists('activity_id');
          // Retrieve Activity details
          $activityToReturn = Activity::with('departureCentre', 'arrivalCentre')->whereIn('activity_id',$relatedActivty)->orderBy('datetime_start','asc')->get();

          return response()->json(compact('activityToReturn'));
        } else {
          $status = array("Missing parameter");
          return response()->json(compact('status'));
        }
    }

    /**
     * Retrieves information for volunteer's activity of the day that is in progress.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JSON  array of status of activity with activity
     */
    public function todayActivityInProgress(Request $request){
      if ($request->get('token') != null){
          // Get Authenticated User
          $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
          $id = $authenticatedUser->volunteer_id;
          // Retrieve Activties within today
          $todayactivities = Activity::whereBetween('datetime_start',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->lists('activity_id');
          //echo count($todayactivities);
          // Retrieve Related Activties within today related to volunteer
          $groupStatus = collect(['pick-up','at check-up','check-up completed']);
          $relatedActivty = Task::whereIn('activity_id',$todayactivities)->where('volunteer_id',$id)->whereIn('status',$groupStatus)->lists('activity_id');
          $taskStatus = Task::whereIn('activity_id',$todayactivities)->whereIn('status',$groupStatus)->where('volunteer_id',$id)->value('status');
          // Retrieve Activity details
          $activityToReturn = Activity::with('departureCentre', 'arrivalCentre')->whereIn('activity_id',$relatedActivty)->first();

          return response()->json(compact('activityToReturn','taskStatus'));
        } else {
          $status = array("Missing parameter");
          return response()->json(compact('status'));
        }
    }

    /**
     * Handles the feedback from users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    Public function sendFeedback(Request $request){
      if ($request->get('email') != null && $request->get('feedback') != null){
        $email = $request->get('email');
        $feedback = $request->get('feedback');
        Mail::send('emails.mobile_account_feedback', compact('email','feedback'), function ($message)  use ($email) {
                    $message->subject('You have a new feedback from a user!');
                    $message->bcc('imchosen6@gmail.com');
                });
        $status = array("Success");
        return response()->json(compact('status'));
      } else {
        $status = array("Missing parameter");
        return response()->json(compact('status'));
      }

    }
}
