<?php

namespace App\Http\Controllers\WebService;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\WebService\VolunteerAuthController;
use Config;
use App\Activity;
use App\Task;
use App\Centre;
use App\Volunteer;
use App\Rank;
use Carbon\Carbon;
use Mail;
use DB;


class ActivitiesController extends Controller
{
    public function __construct()
    {
        // Set the Eloquent model that should be used to retrieve your users
        Config::set('auth.model', 'App\Volunteer');

        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['retrieveTransportActivityDetails', 'retrieveTransportActivity', 'retrieveTransportByUser', 'retrieveRecommendedTransportActivity', 'addNewActivity', 'addUserAccount', 'checkActivityApplication', 'updateActivityStatus', 'withdraw','retrieveFilter']]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function retrieveTransportActivity(Request $request)
    {
        if ($request->get('token') != null){
                $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
                $id = $authenticatedUser->volunteer_id;
                $limit = $request->get('limit');
                $approvedActivities = Activity::with('tasks')
                ->whereHas('tasks', function ($query) {
                    $query->where('approval', 'like', 'approved');
                })->lists('activity_id');

                $appliedActivities = Task::Where('volunteer_id', '=', $id)->where(function($query){
                    $query->where('approval', '=','rejected')
                    ->orWhere('approval', '=','pending');})
                    ->lists('activity_id');


                $activities = Activity::with('departureCentre', 'arrivalCentre')->with('elderly')
                ->UpcomingExact()
                ->whereNotIn('activity_id', $approvedActivities)
                ->whereNotIn('activity_id', $appliedActivities)
                ->get();
                
                
                return response()->json(compact('activities'));
            } else {
                $approvedActivities = Activity::with('tasks')
                ->whereHas('tasks', function ($query) {
                $query->where('approval', 'like', 'approved');
                })->lists('activity_id');

                $activities = Activity::with('departureCentre', 'arrivalCentre')
                ->UpcomingExact()
                ->whereNotIn('activity_id', $approvedActivities)
                ->get();

                //return response()->json($activities);
                return response()->json(compact('activities'));
            }
    }

// tested working with new database 
    public function retrieveTransportActivityDetails(Request $request)
    {
        $id = $request->get('transportId');
        $activity = Activity::with('departureCentre', 'arrivalCentre')->findOrFail($id);

        return response()->json(compact('activity'));
    }
// find activity details that is not completed by user ->1
// find activity details that are completed ->2

    public function retrieveTransportByUser(Request $request)
    {
        if ($request->get('id') == null && $request->get('type') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $id = $request->get('id');
            $type = $request->get('type');

            if ($type == "1"){

                $uncompletedActivities = Task::Where('volunteer_id', '=', $id)
                ->where('tasks.status', '<>', 'completed')
                ->lists('activity_id');

                $activities = Activity::with('departureCentre', 'arrivalCentre','elderly')
                ->whereIn('activity_id', $uncompletedActivities)->orderBy('activity_id','asc')
                ->get();

                //$activities = $activities->sortBy('activity_id');

                $task = Task::where('volunteer_id','=',$id)->whereIn('activity_id', $uncompletedActivities)->orderBy('activity_id','asc')->get();

                //$taskTwo = Activity::with('tasks')->where('volunteer_id','=',$id)->whereIn('activity_id', $uncompletedActivities)->orderBy('datetime_start','desc')->get();
                //$taskTwo = DB::table('activities')->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')->where('tasks.volunteer_id','=',$id)->whereIn('activities.activity_id', $uncompletedActivities)->orderBy('activities.datetime_start','desc')->get();
                //$task = $task->sortBy('activity_id');

               return response()->json(compact('activities','task'));


            } else if($type == "2") {
                $volunteerActivities = Task::Where('volunteer_id', '=', $id)
                ->lists('activity_id');


                $activities = Activity::with('departureCentre', 'arrivalCentre','elderly')
                ->whereIn('activity_id', $volunteerActivities)->orderBy('activity_id','asc')
                ->get();

                $task = Task::where('volunteer_id','=',$id)->whereIn('activity_id', $volunteerActivities)->orderBy('activity_id','asc')->get();
                //$taskTwo = DB::table('activities')->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')->where('tasks.volunteer_id','=',$id)->whereIn('activities.activity_id', $volunteerActivities)->orderBy('activities.datetime_start','desc')->get();
                return response()->json(compact('activities','task'));
            }
        }

    }

// tested working with new database 
    public function retrieveRecommendedTransportActivity(Request $request)
    {
        // retrieve the nearest UpcomingExact activites based on dates
        // limit will be determined by jonathan
        if ($request->get('limit') == null ) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {

            if ($request->get('token') != null){
                $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
                $id = $authenticatedUser->volunteer_id;
                $limit = $request->get('limit');
                $approvedActivities = Activity::with('tasks')
                ->whereHas('tasks', function ($query) {
                    $query->where('approval', 'like', 'approved');
                })->lists('activity_id');

                $appliedActivities = Task::Where('volunteer_id', '=', $id)->where(function($query){
                    $query->where('approval', '=','rejected')
                    ->orWhere('approval', '=','pending');})
                    ->lists('activity_id');


                $activities = Activity::with('departureCentre', 'arrivalCentre')
                ->UpcomingExact()
                ->whereNotIn('activity_id', $approvedActivities)
                ->whereNotIn('activity_id', $appliedActivities)
                ->whereBetween('datetime_start',[Carbon::today(),Carbon::today()->addDays(14)])
                ->take($limit)
                ->get();

                return response()->json(compact('activities'));
            } else {
                $id = $request->get('id');
                $limit = $request->get('limit');
                $approvedActivities = Activity::with('tasks')
                ->whereHas('tasks', function ($query) {
                    $query->where('approval', 'like', 'approved');
                })->lists('activity_id');

                $activities = Activity::with('departureCentre', 'arrivalCentre')
                ->UpcomingExact()
                ->whereNotIn('activity_id', $approvedActivities)
                ->whereBetween('datetime_start',[Carbon::today(),Carbon::today()->addDays(14)])
                ->take($limit)
                ->get();

                return response()->json(compact('activities'));
            }
            
        }


    }

// tested working with new database
    public function addNewActivity(Request $request)
    {
        if ($request->get('volunteer_id') == null || $request->get('activity_id') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $userID = $request->get('volunteer_id');
            $user = Volunteer::findOrFail($userID);
            $actID = $request->get('activity_id');
            $appliedActivity = Activity::findOrFail($actID);

            $task = Task::where('volunteer_id', $userID)->where('activity_id', $actID)->get();
            //return response()->json(compact('email'));

            if ($task->isEmpty()) {
                $user->activities()->attach($actID);
                $status = array("Application Successful");
                Mail::send('emails.volunteer_apply', compact('user','appliedActivity'), function ($message) {
                    $message->from('imchosen6@gmail.com', 'CareGuide Adminstrator');
                    $message->subject('A volunteer has applied for an activity');
                    $message->to('imchosen6@gmail.com');
                });
                return response()->json(compact('status'));
            } elseif (sizeof($task)> 0) {
                $taskUpdate = $task->first();
                $taskUpdate->approval = "pending";
                $taskUpdate->save();
                Mail::send('emails.volunteer_apply', compact('user','appliedActivity'), function ($message) {
                    $message->from('imchosen6@gmail.com', 'CareGuide Adminstrator');
                    $message->subject('A volunteer has applied for an activity');
                    $message->to('imchosen6@gmail.com');
                });
                $status = array("Reapplication Successful");
                return response()->json(compact('status'));
            } else {
                $status = array("error");
                return response()->json(compact('status'));
            }
        }


    }

// tested working with new database 
    public function checkActivityApplication(Request $request)
    {

        if ($request->get('volunteer_id') == null || $request->get('activity_id') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $userID = $request->get('volunteer_id');
            $actID = $request->get('activity_id');

            $withdrawnTask = Task::where('volunteer_id', $userID)->where('activity_id', $actID)->where('approval', '=' , 'withdrawn')->lists('activity_id');
            //return response()->json(compact('withdrawnTask'));

            $applyingActivity = Activity::findOrFail($actID);

            if ($applyingActivity == null){
                $status = array("do not exist");
                return response()->json(compact('status'));
            } else {
               $activityStartTime = $applyingActivity->datetime_start;
               $activityDuration = $applyingActivity->expected_duration_minutes;
               $activityEndTime = $applyingActivity->datetime_start->addMinutes($activityDuration);
               $activityFullDayStart = $applyingActivity->datetime_start->startOfDay()->toDateTimeString();
               $activityFullDayEnd = $applyingActivity->datetime_start->endOfDay()->toDateTimeString();
                
               
                //$sameTimeTask = Activity::where('datetime_start', '=', $activityStartTime)->lists('activity_id');

                $activitiesOnSameDay = Activity::whereBetween('datetime_start', [$activityFullDayStart,$activityFullDayEnd ])->where('activity_id','<>',$actID)->lists('activity_id');
                //echo $activitiesOnSameDay;
                //echo  $sameTimeTaskWithEnd;
                $status = ['rejected'];

                $taskofUserOnSameDay = Task::where('volunteer_id',$userID)->whereIn('activity_id',$activitiesOnSameDay)->whereNotIn('approval',$status)->lists('activity_id');
                //echo $taskofUserOnSameDay;
                $check = false;
                foreach ($taskofUserOnSameDay as $activityID){
                    $activity = Activity::find($activityID);
                    $bStartTime = $activity->datetime_start;
                    $bDuration = $activity->expected_duration_minutes;
                    $bEndTime = $activity->datetime_start->addMinutes($bDuration);
                    
                    if ($activityStartTime->lte($bStartTime) &&  $bStartTime->lte($activityEndTime) && $activityEndTime->lte($bEndTime)){
                       $check = true;
                    }
                    if ($bStartTime->lte($activityStartTime) &&  $activityStartTime->lte($bEndTime) && $bEndTime->lte($activityEndTime)){
                       $check = true;
                    }
                    if ($activityStartTime->lte($bStartTime) &&  $bStartTime->lte($activityEndTime) && $bEndTime->lte($activityEndTime)){
                       $check = true;
                    }
                    if ($bStartTime->lte($activityStartTime) &&  $activityStartTime->lte($bEndTime) && $activityEndTime->lte($bEndTime)){
                       $check = true;
                    }
                    if ($activityStartTime->eq($bStartTime) &&  $activityEndTime->eq($bEndTime) ){
                       $check = true;
                    }


                }

                //echo $taskWithSameTime;
                /*$sameTimeTask = Task::with('activities')
                ->whereHas('activities', function ($query) {
                    $query->where('datetime_start', '=', '2016-02-14 21:00:00');
                })->lists('activity_id');*/

                //echo  $sameTimeTask;


                //$task = Task::where('volunteer_id', $userID)->where('activity_id', $actID)->whereNotIn('activity_id', $withdrawnTask)->get();
                //return response()->json(compact('email'));


                if (!$check) {
                    $status = array("do not exist");
                    return response()->json(compact('status'));
                } else {
                    $status = array("exist");
                    return response()->json(compact('status'));
                } 
            }

            

        }

    }

// tested working with new database , pending update from task.php
    public function updateActivityStatus(Request $request)
    {
        if ($request->get('volunteer_id') == null || $request->get('activity_id') == null || $request->get('status') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $volunteer_id = $request->get('volunteer_id');
            $activity_id = $request->get('activity_id');
            $status = $request->get('status');

            $task = Task::where('volunteer_id', $volunteer_id)->where('activity_id', $activity_id)->update(['status' => $status]);
            //$checkTask = Task::where('volunteer_id',$volunteer_id)->where('activity_id',$activity_id)->get();

            if ($status == "completed"){
                $activity = Activity::findOrFail($activity_id);
                $timeToAdd =$activity->expected_duration_minutes;
                $volunteer = Volunteer::findOrFail($volunteer_id);
                $currentTime=$volunteer->minutes_volunteered;
                $volunteer->minutes_volunteered=$timeToAdd + $currentTime;
                $newTime = floor($volunteer->minutes_volunteered / 60);
                $newRank = Rank::where('min','<',$newTime)->value('rank_id');
                $volunteer->rank_id=$newRank;
                $volunteer->save();
            }

            $status = array("Update Successful");
            return response()->json(compact('status'));
            //$check = Task::findOrFail($task->id);
        }
    }

// New Error types
    public function withdraw(Request $request)
    {
        if ($request->get('volunteer_id') == null || $request->get('activity_id') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $volunteer_id = $request->get('volunteer_id');
            $activity_id = $request->get('activity_id');
            $volunteer = Volunteer::findOrFail($volunteer_id);
            $withdrawnActivity = Activity::findOrFail($activity_id);

            $task = Task::where('volunteer_id', $volunteer_id)->where('activity_id', $activity_id)->update(['approval' => 'withdrawn']);
            //$checkTask = Task::where('volunteer_id',$volunteer_id)->where('activity_id',$activity_id)->get();

            $status = array("Withdrawn from activity.");
            Mail::send('emails.volunteer_withdraw', compact('volunteer','withdrawnActivity'), function ($message) {
                    $message->from('imchosen6@gmail.com', 'CareGuide Adminstrator');
                    $message->subject('A volunteer has withdrawn from an activity');
                    $message->to('imchosen6@gmail.com');
                });
            return response()->json(compact('status'));
            //$check = Task::findOrFail($task->id);
        }
    }

    public function retrieveFilter(Request $request)
    {
        if ($request->get('filter') == null){
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $filter = $request->get('filter');

            if ($filter == 'start'){
                if ($request->get('token') != null){
                        $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
                        $id = $authenticatedUser->volunteer_id;
                        $limit = $request->get('limit');
                        $approvedActivities = Activity::with('tasks')
                        ->whereHas('tasks', function ($query) {
                            $query->where('approval', 'like', 'approved');
                        })->lists('activity_id');

                        $appliedActivities = Task::Where('volunteer_id', '=', $id)->where(function($query){
                            $query->where('approval', '=','rejected')
                            ->orWhere('approval', '=','pending');})
                            ->lists('activity_id');

                        $notApproved = Task::where('approval','=','approved')->distinct()->lists('activity_id');
                        //echo $notApproved;
                        $activityList = Activity::whereNotIn('activity_id',$notApproved)->groupBy('location_from_id')->lists('location_from_id');
                        //echo $activityList;
                        $toReturn = [];
                        foreach ($activityList as $location){
                            //echo $location;
                            $locationName = Centre::findOrFail($location)->name;
                            //echo $location;
                            
                            $locationList = Activity::where('datetime_start','>',Carbon::now())->whereNotIn('activity_id',$approvedActivities)->whereNotIn('activity_id',$appliedActivities)->whereNotIn('activity_id',$notApproved)->where('location_from_id',$location)->distinct()->lists('activity_id');
                            //$toReturn = array();

                            if (!$locationList->isEmpty()){
                                array_push($toReturn, array("location_from" => $locationName, "activity_ids" => implode(",", $locationList->toArray())));
                            }
                        }
                        return response()->json($toReturn);
                    } else {
                        $notApproved = Task::where('approval','=','approved')->distinct()->lists('activity_id');
                        //echo $notApproved;
                        $activityList = Activity::whereNotIn('activity_id',$notApproved)->groupBy('location_from_id')->lists('location_from_id');
                        //echo $activityList;
                        $toReturn = [];
                        foreach ($activityList as $location){
                            //echo $location;
                            $locationName = Centre::findOrFail($location)->name;
                            //echo $location;
                            
                            $locationList = Activity::where('datetime_start','>',Carbon::now())->whereNotIn('activity_id',$notApproved)->where('location_from_id',$location)->distinct()->lists('activity_id');
                            //$toReturn = array();

                            if (!$locationList->isEmpty()){
                                array_push($toReturn, array("location_from" => $locationName, "activity_ids" => implode(",", $locationList->toArray())));
                            }
                        }
                        

                        return response()->json($toReturn);
                    }

                

            }elseif ($filter == 'end') {
                if ($request->get('token') != null){
                        $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
                        $id = $authenticatedUser->volunteer_id;
                        $limit = $request->get('limit');
                        $approvedActivities = Activity::with('tasks')
                        ->whereHas('tasks', function ($query) {
                            $query->where('approval', 'like', 'approved');
                        })->lists('activity_id');

                        $appliedActivities = Task::Where('volunteer_id', '=', $id)->where(function($query){
                            $query->where('approval', '=','rejected')
                            ->orWhere('approval', '=','pending');})
                            ->lists('activity_id');
                        $notApproved = Task::where('approval','=','approved')->distinct()->lists('activity_id');
                        $notcompleted = Task::where('status','=','completed')->distinct()->lists('activity_id');
                        $activityList = Activity::groupBy('location_to_id')->lists('location_to_id');
                        $toReturn = [];
                        $locationNameString = "";
                        $locationIdString = "";
                        foreach ($activityList as $location){
                            $locationName = Centre::findOrFail($location)->name;
                            //echo $location;
                            $notApproved = Task::where('approval','=','approved')->distinct()->lists('activity_id');
                            $locationList = Activity::where('datetime_start','>',Carbon::now())->whereNotIn('activity_id',$approvedActivities)->whereNotIn('activity_id',$appliedActivities)->where('location_to_id',$location)->whereNotIn('activity_id',$notApproved)->distinct()->lists('activity_id');
                            //$stringToTitle = 'location_to';
                            $stringToList = $locationName . ' ' . $locationList;
                            //$locationNameString = $locationNameString . ',' .  $locationName;
                            //$locationIdString = $locationIdString . ',' . $locationList;
                            //$toReturn = array();

                            if (!$locationList->isEmpty()){
                                array_push($toReturn, array("location_to" => $locationName, "activity_ids" => implode(",", $locationList->toArray())));
                            }
                        }
                        

                        return response()->json($toReturn);
                    }else {
                        $notApproved = Task::where('approval','=','approved')->distinct()->lists('activity_id');
                        $notcompleted = Task::where('status','=','completed')->distinct()->lists('activity_id');
                        $activityList = Activity::groupBy('location_to_id')->lists('location_to_id');
                        $toReturn = [];
                        $locationNameString = "";
                        $locationIdString = "";
                        foreach ($activityList as $location){
                            $locationName = Centre::findOrFail($location)->name;
                            //echo $location;
                            $notApproved = Task::where('approval','=','approved')->distinct()->lists('activity_id');
                            $locationList = Activity::where('datetime_start','>',Carbon::now())->where('location_to_id',$location)->whereNotIn('activity_id',$notApproved)->distinct()->lists('activity_id');
                            //$stringToTitle = 'location_to';
                            $stringToList = $locationName . ' ' . $locationList;
                            //$locationNameString = $locationNameString . ',' .  $locationName;
                            //$locationIdString = $locationIdString . ',' . $locationList;
                            //$toReturn = array();

                            if (!$locationList->isEmpty()){
                                array_push($toReturn, array("location_to" => $locationName, "activity_ids" => implode(",", $locationList->toArray())));
                            }
                        }
                        

                        return response()->json($toReturn);
                    }
                
            }else {
                if ($request->get('token') != null){
                        $authenticatedUser = JWTAuth::setToken($request->get('token'))->authenticate();
                        $id = $authenticatedUser->volunteer_id;
                        $limit = $request->get('limit');
                        $approvedActivities = Activity::with('tasks')
                        ->whereHas('tasks', function ($query) {
                            $query->where('approval', 'like', 'approved');
                        })->lists('activity_id');

                        $appliedActivities = Task::Where('volunteer_id', '=', $id)->where(function($query){
                            $query->where('approval', '=','rejected')
                            ->orWhere('approval', '=','pending');})
                            ->lists('activity_id');
                        $activityList = Activity::groupBy('datetime_start')->lists('datetime_start');
                        $toReturn = [];
                        foreach ($activityList as $dateTimeStart){
                            $notApproved = Task::where('approval','=','approved')->distinct()->lists('activity_id');
                            $locationList = Activity::where('datetime_start','>',Carbon::now())->whereNotIn('activity_id',$approvedActivities)->whereNotIn('activity_id',$appliedActivities)->whereNotIn('activity_id',$notApproved)->where('datetime_start','=',$dateTimeStart)->whereNotIn('activity_id',$notApproved)->distinct()->lists('activity_id');
                            
                            //$toReturn = array();

                            if (!$locationList->isEmpty()){
                                array_push($toReturn, array("time" => $dateTimeStart, "activity_ids" => implode(",", $locationList->toArray())));
                            }
                        }
                        

                        return response()->json($toReturn);
                    } else {
                        $activityList = Activity::groupBy('datetime_start')->lists('datetime_start');
                        $toReturn = [];
                        foreach ($activityList as $dateTimeStart){
                            $notApproved = Task::where('approval','=','approved')->distinct()->lists('activity_id');
                            $locationList = Activity::where('datetime_start','>',Carbon::now())->whereNotIn('activity_id',$notApproved)->where('datetime_start','=',$dateTimeStart)->whereNotIn('activity_id',$notApproved)->distinct()->lists('activity_id');
                            
                            //$toReturn = array();

                            if (!$locationList->isEmpty()){
                                array_push($toReturn, array("time" => $dateTimeStart, "activity_ids" => implode(",", $locationList->toArray())));
                            }
                        }
                        

                        return response()->json($toReturn);
                    }
                

            }
            
        }
        
        


        
    }

}
