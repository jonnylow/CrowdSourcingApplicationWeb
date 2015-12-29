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
use Carbon\Carbon;



class ActivitiesController extends Controller
{
    public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['retrieveTransportActivityDetails', 'retrieveTransportActivity' ,'RetrieveTransportByUser']]);
   }

   /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function retrieveTransportActivity(Request $request)
    {
        $activities = Activity::upcoming()->get();
        

        foreach($activities as $activity){
          echo $activity->activity_id;
          $tasks = Task::ofActivity($activity->activity_id)->get();
          
          foreach($tasks as $task){
            //echo $task->approval;
            if ($task->approval == 'approved'){
              //echo 'deleting +' + $task->task_id;
              //echo $task->task_id;
              //$activities = array_forget('activity');
              $finalList = array_add($activity);
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

    public function RetrieveRecommendedTransportActivity(Request $request){
      // retrieve the nearest upcoming activites based on dates 
      // limit will be determined by jonathan
    }
}
