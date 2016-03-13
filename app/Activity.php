<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Activity extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';
    protected $primaryKey = 'activity_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['datetime_start', 'expected_duration_minutes',
        'category', 'more_information', 'location_from_id', 'location_to_id',
         'elderly_id', 'centre_id', 'staff_id'];

    /**
     * Additional fields to treat as Carbon instances (date object).
     */
    protected $dates = ['datetime_start', 'deleted_at'];

    /*
     * Overwrite the boot function of Eloquent Model to listen for deleting event so as to
     * cancel all associated tasks when an activity is cancelled.
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
     * Scope queries to activities that have passed.
     *
     * @var query
     */
    public function scopePast($query)
    {
        $query->where('datetime_start', '<', Carbon::today())->latest('datetime_start');
    }

    /**
     * Scope queries to activities that starts today.
     *
     * @var query
     */
    public function scopeToday($query)
    {
        $query->whereBetween('datetime_start', [Carbon::today(), Carbon::now()->endOfDay()])->oldest('datetime_start');
    }

    /**
     * Scope queries to activities that have not passed today.
     *
     * @var query
     */
    public function scopeUpcoming($query)
    {
        $query->where('datetime_start', '>', Carbon::now()->endOfDay())->oldest('datetime_start');
    }

    /**
     * Scope queries to activities that have not passed from the current exact time.
     *
     * @var query
     */
    public function scopeUpcomingExact($query)
    {
        $query->where('datetime_start', '>', Carbon::now())->oldest('datetime_start');
    }

    /**
     * Scope queries to activities in certain month ago.
     *
     * @var query
     */
    public function scopeSubMonth($query, $month)
    {
        $query->whereBetween('datetime_start', [Carbon::now()->subMonth($month)->startOfMonth(),
            Carbon::now()->subMonth($month)->endOfMonth()]);
    }

    /**
     * Scope queries to activities that are cancelled.
     *
     * @var query
     */
    public function scopeCancelled($query)
    {
        $query->onlyTrashed()->latest('datetime_start');
    }

    /**
     * Scope queries to activities that are completed.
     *
     * @var query
     */
    public function scopeCompleted($query)
    {
        $query->withTrashed()
            ->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where('tasks.status', 'completed')->latest('datetime_start');
    }

    /**
     * Scope queries to activities that are unfilled (upcoming and no sign-up).
     *
     * @var query
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
     * Scope queries to activities that are urgent (starting in a week and no sign-up).
     *
     * @var query
     */
    public function scopeUrgent($query)
    {
        $query->unfilled()
            ->where('datetime_start', '<', Carbon::today()->addWeek(2));
    }

    /**
     * Scope queries to activities that are awaiting approval.
     *
     * @var query
     */
    public function scopeAwaitingApproval($query)
    {
        $query->upcoming()
            ->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where('tasks.approval', 'pending');
    }

    /**
     * Scope queries to activities that have approved volunteer.
     *
     * @var query
     */
    public function scopeApproved($query)
    {
        $query->upcoming()
            ->join('tasks', 'activities.activity_id', '=', 'tasks.activity_id')
            ->where('tasks.approval', 'approved');
    }

    /**
     * Scope queries to activities that belongs to the centre.
     *
     * @var query
     */
    public function scopeOfCentre($query, $centreId)
    {
        $query->where('centre_id', $centreId);
    }

    /**
     * Scope queries to activities that belongs to all centres associated with the staff.
     *
     * @var $query
     * @var $staff
     */
    public function scopeOfCentreForStaff($query, $staff)
    {
        $query->whereIn('centre_id', $staff->centres->lists('centre_id'));
    }


    /**
     * Find if the activity has an approved volunteer.
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
     * Get the approved volunteer(if any) for the activity, else return NULL.
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
     * Get the application status of the activity.
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
                return "No application <span class=\"fa fa-circle circle-red\" style=\"color:#E74C3C\"></span>";
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
                    return "Application confirmed <span class=\"fa fa-circle circle-green\" style=\"color:#18BC9C\"></span>";
                } else if ($groupByApproval->has('pending')) {
                    return "Application(s) received <span class=\"fa fa-circle circle-orange\" style=\"color:#F39C12\"></span>";
                } else if ($groupByApproval->has('withdrawn')) {
                    return "No application <span class=\"fa fa-circle circle-red\" style=\"color:#E74C3C\"></span>";
                } else if ($groupByApproval->has('rejected')) {
                    return "No application <span class=\"fa fa-circle circle-red\" style=\"color:#E74C3C\"></span>";
                }
            }
        }
    }

    /**
     * Get the application status of the activity for tooltip display.
     */
    public function getTooltipStatus()
    {
        $status = $this->getApplicationStatus();

        if (starts_with($status, "Completed")) {
            return "Activity has completed";
        } else if (starts_with($status, "Not completed")) {
            return "Activity has passed";
        } else if (starts_with($status, "Senior")) {
            return "Activity is in progress";
        } else if (starts_with($status, "Application confirmed")) {
            return "Activity has confirmed volunteer";
        } else if (starts_with($status, "Application(s) received")) {
            return "Activity has volunteer waiting for approval";
        } else if ($this->datetime_start->isToday()) {
            if ($this->datetime_start->isPast()) {
                return "Activity has passed";
            } else {
                return "Activity is today";
            }
        }
    }

    /**
     * Set the activity's starting date and time.
     */
    public function setDatetimeStartAttribute($datetime)
    {
        $this->attributes['datetime_start'] = Carbon::parse($datetime);
    }

    /**
     * Get the hour section of the activity's duration, minutes are not retrieved.
     *
     * @return string
     */
    public function durationHour()
    {
        return floor($this->expected_duration_minutes / 60);
    }

    /**
     * Get the minute section of the activity's duration, hours are not retrieved.
     *
     * @return string
     */
    public function durationMinute()
    {
        return ($this->expected_duration_minutes % 60);
    }

    /**
     * Get the activity's duration in text.
     *
     * @return string
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
     */
    public function elderly()
    {
        return $this->belongsTo('App\Elderly');
    }

    /**
     * Get the centre that the activity belongs to.
     */
    public function centre()
    {
        return $this->belongsTo('App\Centre');
    }

    /**
     * Get the centre that the activity will start from.
     */
    public function departureCentre()
    {
        return $this->belongsTo('App\Centre', 'location_from_id');
    }

    /**
     * Get the centre that the activity will go to.
     */
    public function arrivalCentre()
    {
        return $this->belongsTo('App\Centre', 'location_to_id');
    }

    /**
     * Get the staff that created the activity.
     */
    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    /**
     * The task application that is associated with the activity.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * The volunteer registry that is associated with the activity.
     */
    public function volunteers()
    {
        return $this->belongsToMany('App\Volunteer', 'tasks', 'activity_id', 'volunteer_id')
            ->withPivot('status', 'approval', 'comment')
            ->withTimestamps();
    }
}
