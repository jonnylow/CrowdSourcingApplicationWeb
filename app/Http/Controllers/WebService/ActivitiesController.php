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
use App\Centre;
use Carbon\Carbon;


class ActivitiesController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['retrieveTransportActivityDetails', 'retrieveTransportActivity', 'retrieveTransportByUser', 'retrieveRecommendedTransportActivity', 'addNewActivity', 'addUserAccount', 'checkActivityApplication', 'updateActivityStatus', 'withdraw']]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function retrieveTransportActivity(Request $request)
    {
        $activities = Activity::with('departureCentre', 'arrivalCentre')->upcoming()
            ->select('activities.*')
            ->leftJoin('tasks', function ($join) {
                $join->on('activities.activity_id', '=', 'tasks.activity_id');
            })
            ->whereNull('tasks.activity_id')
            ->orWhere('approval', '<>', 'approved')
            ->distinct()
            ->get();
        return response()->json(compact('activities'));
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
            $activity = Activity::findOrFail($id);
            return response()->json(compact('activity'));
        }

    }

// tested working with new database 
    public function retrieveRecommendedTransportActivity(Request $request)
    {
        // retrieve the nearest upcoming activites based on dates
        // limit will be determined by jonathan
        if ($request->get('limit') == null) {
            $status = array("Missing parameter");
            return response()->json(compact('status'));
        } else {
            $limit = $request->get('limit');
            $activities = Activity::upcoming()->with('departureCentre', 'arrivalCentre')->get()->take($limit);
            return response()->json(compact('activities'));
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

            $task = Task::where('volunteer_id', $userID)->where('activity_id', $actID)->get();
            //return response()->json(compact('email'));

            if ($task->isEmpty()) {
                $user->activities()->attach($actID);
                $status = array("Application Successful");
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

            $task = Task::where('volunteer_id', $userID)->where('activity_id', $actID)->get();
            //return response()->json(compact('email'));

            if ($task->isEmpty()) {
                $status = array("do not exist");
                return response()->json(compact('status'));
            } else {
                $status = array("exist");
                return response()->json(compact('status'));
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

            $status = array("Application Successful");
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

            $task = Task::where('volunteer_id', $volunteer_id)->where('activity_id', $activity_id)->update(['approval' => 'withdrawn']);
            //$checkTask = Task::where('volunteer_id',$volunteer_id)->where('activity_id',$activity_id)->get();

            $status = array("Withdrawn from activity.");
            return response()->json(compact('status'));
            //$check = Task::findOrFail($task->id);
        }
    }

        


}
