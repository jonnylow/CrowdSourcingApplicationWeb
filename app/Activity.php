<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Activity class that interact with its corresponding table in the database.
 * This model allows for soft delete, where records are not actually deleted from the database.
 *
 * @package App
 */
class Activity extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * The primary key in the database table.
     *
     * @var string
     */
    protected $primaryKey = 'activity_id';

    /**
     * The attributes in the database table that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['datetime_start', 'expected_duration_minutes',
        'category', 'more_information', 'location_from_id', 'location_to_id',
         'elderly_id', 'centre_id', 'staff_id'];

    /**
     * Additional fields to be mutated to Carbon instances (date object).
     *
     * @var array
     */
    protected $dates = ['datetime_start', 'deleted_at'];

    /*
     * Overwrite the boot function in Eloquent Model to listen for deletion/restoration events
     * so as to delete/restore all associated tasks when an activity is deleted/restored.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();

        Activity::deleting(function($activity) {
            foreach($activity->tasks as $task) {
                $task->delete();
            }
        });

        Activity::restored(function($activity) {
            foreach($activity->tasks as $task) {
                $task->restore();
            }
        });
    }

    /**
     * Scope a query to only include activities (in descending date order) that have passed the current date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePast($query)
    {
        $query->where('datetime_start', '<', Carbon::today())->latest('datetime_start');
    }

    /**
     * Scope a query to only include activities (in ascending date order) that starts on the current date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        $query->whereBetween('datetime_start', [Carbon::today(), Carbon::now()->endOfDay()])->oldest('datetime_start');
    }

    /**
     * Scope a query to only include activities (in ascending date order) that have not passed the current date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        $query->where('datetime_start', '>', Carbon::now()->endOfDay())->oldest('datetime_start');
    }

    /**
     * Scope a query to only include activities (in ascending date order) that have not passed the current exact datetime.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcomingExact($query)
    {
        $query->where('datetime_start', '>', Carbon::now())->oldest('datetime_start');
    }

    /**
     * Scope a query to only include activities that starts in a certain month.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @param  int  $month  the number of months to be subtracted from the current month
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubMonth($query, $month = 0)
    {
        $query->whereBetween('datetime_start', [Carbon::now()->subMonth($month)->startOfMonth(),
            Carbon::now()->subMonth($month)->endOfMonth()]);
    }

    /**
     * Scope a query to only include activities that are cancelled/soft deleted.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCancelled($query)
    {
        $query->onlyTrashed()->latest('datetime_start');
    }

    /**
     * Scope a query to only include activities that are completed.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        $query->withTrashed()
            ->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where('tasks.status', 'completed')->latest('datetime_start');
    }

    /**
     * Scope a query to only include activities that have no sign-up and not passed the current date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnfilled($query)
    {
        $query->select('activities.*')
            ->leftJoin('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where(function ($query) {
                $query->whereNull('tasks.approval')
                    ->orWhere(function ($orQuery) {
                        $orQuery->whereNotIn('tasks.approval', ['pending', 'approved']);
                    });
            })->upcoming();
    }

    /**
     * Scope a query to only include activities that have no sign-up and are starting within 2 weeks time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUrgent($query)
    {
        $query->unfilled()
            ->where('datetime_start', '<', Carbon::today()->addWeek(2));
    }

    /**
     * Scope a query to only include activities that have volunteers signed up and waiting for approval.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAwaitingApproval($query)
    {
        $query->upcoming()
            ->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where('tasks.approval', 'pending');
    }

    /**
     * Scope a query to only include activities that have volunteers that are approved for activity.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        $query->upcoming()
            ->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where('tasks.approval', 'approved');
    }

    /**
     * Scope a query to only include activities that belongs to the centre specified.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @param  int  $centreId  the ID of the centre of the activities
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCentre($query, $centreId)
    {
        $query->where('centre_id', $centreId);
    }

    /**
     * Scope a query to only include activities that belongs to all centres that the specified staff are in charge of.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to activities to be scoped
     * @param  \App\Staff  $staff  the staff to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCentreForStaff($query, $staff)
    {
        $query->whereIn('centre_id', $staff->centres->lists('centre_id'));
    }


    /**
     * See if the activity has volunteer that are approved for it.
     *
     * @return  bool  TRUE if the activity has approved volunteer, FALSE otherwise.
     */
    public function hasApprovedVolunteer()
    {
        $volunteers = $this->volunteers()->get();
        foreach($volunteers as $volunteer) {
            if($volunteer->pivot->approval == 'approved')
                return true;
        }
        return false;
    }

    /**
     * Get the approved volunteer for the activity.
     *
     * @return  \App\Volunteer  the volunteer if the activity has approved volunteer, NULL otherwise.
     */
    public function getApprovedVolunteer()
    {
        $volunteers = $this->volunteers()->get();
        foreach($volunteers as $volunteer) {
            if($volunteer->pivot->approval == 'approved')
                return $volunteer;
        }
        return null;
    }

    /**
     * Get the current progress of the activity.
     *
     * @return  int  the progress of the activity from 0 to 100 (not started to completed).
     */
    public function getProgress()
    {
        $tasks = $this->tasks;
        $taskCount = $tasks->count();

        if ($taskCount == 0) {
            return 0; // Not Started
        } else {
            $groupByStatus = $tasks->groupBy('status');

            if ($groupByStatus->has('completed')) {
                return 100; // Completed
            } else if ($groupByStatus->has('pick-up')) {
                return 25; // Picked-up
            } else if ($groupByStatus->has('at check-up')) {
                return 50; // At Check-up
            } else if ($groupByStatus->has('check-up completed')) {
                return 75; // Check-up Completed
            } else {
                return 0; // Not Started
            }
        }
    }

    /**
     * Get the status of the activity.
     *
     * @return  string  the status of the activity.
     */
    public function getApplicationStatus()
    {
        $tasks = $this->tasks;
        $taskCount = $tasks->count();

        if($this->datetime_start->isPast() && ! $this->datetime_start->isToday()) {
            $groupByStatus = $tasks->groupBy('status');

            if($groupByStatus->has('completed')) {
                return "Completed";
            } else {
                return "Not completed";
            }
        } else { // Any activity that starts today or in the future
            if ($taskCount == 0) {
                return "<span class=\"fa fa-circle circle-red\" style=\"color:#E74C3C\"></span> No application";
            } else {
                $groupByStatus = $tasks->groupBy('status');
                $groupByApproval = $tasks->groupBy('approval');

                if ($groupByStatus->has('completed')) {
                    return "Completed";
                } else if ($groupByStatus->has('pick-up')) {
                    return "Senior picked-up";
                } else if ($groupByStatus->has('at check-up')) {
                    return "Senior at check-up";
                } else if ($groupByStatus->has('check-up completed')) {
                    return "Senior check-up completed";
                } else if ($groupByApproval->has('approved')) {
                    return "<span class=\"fa fa-circle circle-green\" style=\"color:#18BC9C\"></span> Application confirmed";
                } else if ($groupByApproval->has('pending')) {
                    return "<span class=\"fa fa-circle circle-orange\" style=\"color:#F39C12\"></span> Application(s) received";
                } else if ($groupByApproval->has('withdrawn')) {
                    return "<span class=\"fa fa-circle circle-red\" style=\"color:#E74C3C\"></span> No application";
                } else if ($groupByApproval->has('rejected')) {
                    return "<span class=\"fa fa-circle circle-red\" style=\"color:#E74C3C\"></span> No application";
                }
            }
        }
    }

    /**
     * Get the reason of the activity when it cannot be edited.
     *
     * @return  string  the reason of the activity if the activity cannot be edited, BLANK string otherwise.
     */
    public function getTooltipStatus()
    {
        $status = $this->getApplicationStatus();

        if (str_contains($status, "Completed")) {
            return "Activity has completed";
        } else if (str_contains($status, "Not completed")) {
            return "Activity has passed";
        } else if (str_contains($status, "Senior")) {
            return "Activity is in progress";
        } else if (str_contains($status, "Application confirmed")) {
            return "Activity has confirmed volunteer";
        } else if (str_contains($status, "Application(s) received")) {
            return "Activity has volunteer waiting for approval";
        } else if ($this->datetime_start->isToday()) {
            if ($this->datetime_start->isPast()) {
                return "Activity has passed";
            } else {
                return "Activity is today";
            }
        }

        return "";
    }

    /**
     * Set the activity's starting date and time.
     *
     * @param  string  $datetime  the starting date and time in DateTime string format
     * @return void
     */
    public function setDatetimeStartAttribute($datetime)
    {
        $this->attributes['datetime_start'] = Carbon::parse($datetime);
    }

    /**
     * Get the activity's duration only in hours, minutes portion are not retrieved.
     *
     * @return  int  the activity's duration in hour(s).
     */
    public function durationHour()
    {
        return floor($this->expected_duration_minutes / 60);
    }

    /**
     * Get the activity's duration only in minutes, hours portion are not retrieved.
     *
     * @return    int    the activity's duration in minute(s).
     */
    public function durationMinute()
    {
        return ($this->expected_duration_minutes % 60);
    }

    /**
     * Get the activity's duration in textual form.
     *
     * @return  string  the activity's duration.
     */
    public function durationString()
    {
        $time = $this->expected_duration_minutes;

        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf('%0d hour, %0d min', $hours, $minutes);
    }

    /**
     * Get the elderly associated with the activity.
     *
     * @return  \App\Elderly  the elderly associated with the activity.
     */
    public function elderly()
    {
        return $this->belongsTo('App\Elderly');
    }

    /**
     * Get the centre that the activity belongs to.
     *
     * @return  \App\Centre  the centre that the activity belongs to.
     */
    public function centre()
    {
        return $this->belongsTo('App\Centre');
    }

    /**
     * Get the centre that the activity will start from.
     *
     * @return  \App\Centre  the centre that the activity will start from.
     */
    public function departureCentre()
    {
        return $this->belongsTo('App\Centre', 'location_from_id');
    }

    /**
     * Get the centre that the activity will go to.
     *
     * @return  \App\Centre  the centre that the activity will go to.
     */
    public function arrivalCentre()
    {
        return $this->belongsTo('App\Centre', 'location_to_id');
    }

    /**
     * Get the staff that created the activity.
     *
     * @return  \App\Staff  the staff that created the activity.
     */
    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    /**
     * Get the task applications that are associated with the activity.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of task applications that are associated with the activity.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * Get the volunteers that are associated with the activity.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of volunteers that are associated with the activity.
     */
    public function volunteers()
    {
        return $this->belongsToMany('App\Volunteer', 'tasks', 'activity_id', 'volunteer_id')
            ->withPivot('status', 'approval', 'comment')
            ->withTimestamps();
    }
}
