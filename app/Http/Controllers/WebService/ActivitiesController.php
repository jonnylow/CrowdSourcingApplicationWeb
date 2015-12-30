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



class ActivitiesController extends Controller
{
    public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['retrieveTransportActivityDetails', 'retrieveTransportActivity' ,'retrieveTransportByUser','retrieveRecommendedTransportActivity','addNewActivity','addUserAccount']]);
   }

   /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function retrieveTransportActivity(Request $request)
    {
        $activities = Activity::upcoming()->get();
        $finalList = collect([]);
        

        foreach($activities as $activity){
          echo $activity->activity_id;
          $tasks = Task::ofActivity($activity->activity_id)->get();
          
          foreach($tasks as $task){
            //echo $task->approval;
            if ($task->approval == 'approved'){
              //echo 'deleting +' + $task->task_id;
              //echo $task->task_id;
              //$activities = array_forget('activity');
              $finalList->put($activity);
            }

          }
          echo ' ';
        }
        /*$activities = DB::table('activities')
          ->join('tasks', 'activities.activity_id' , '=', 'tasks.activity_id')
          ->where('task.approval','<>','approved')
          ->get();*/

        return response()->json(compact('finalList'));

        // all good so return the token
        //return response()->json(compact('activities'));
    }

    public function retrieveTransportActivityDetails(Request $request){
        $id = $request->only('transportId');
        $activity = Activity::findOrFail($id);


        return response()->json(compact('activity'));
    }
// find activity details that is not completed by user ->1
// find activity details that are completed ->2

    public function RetrieveTransportByUser(Request $request){
        $id = $request->only('transportId');
        $activity = Activity::findOrFail($id);


        return response()->json(compact('activity'));
    }

    public function retrieveRecommendedTransportActivity(Request $request){
      // retrieve the nearest upcoming activites based on dates 
      // limit will be determined by jonathan
      $limit = $request->get('limit');
      $activities = Activity::upcoming()->get()->sortby('datetime_start');
    }

    public function addNewActivity(Request $request){
      $userID = $request->get('volunteer_id');
      $user = Volunteer::findOrFail($userID);
      $actID = $request->get('activity_id');
      $user->activities()->attach($actID);
      
      $task = Task::where('volunteer_id',$userID)->where('activity_id',$actID)->get();
    //return response()->json(compact('email'));

      if ($task->isEmpty()){
        $status = array("error");
        return response()->json(compact('status'));
      } else {
        $status = array("Application Successful");
        return response()->json(compact('status'));
      }


    }

    public function checkActivityApplication(Request $request){
      $userID = $request->get('volunteer_id');
      $actID = $request->get('activity_id');
      
      $task = Task::where('volunteer_id',$userID)->where('activity_id',$actID)->get();
    //return response()->json(compact('email'));

      if ($task->isEmpty()){
        $status = array("do not exist");
        return response()->json(compact('status'));
      } else {
        $status = array("exist");
        return response()->json(compact('status'));
      }

      
    }
}
