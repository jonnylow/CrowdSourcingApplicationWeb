<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
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
     *1
     * @var array
     */
    protected $dates = ['datetime_start'];

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
     * Scope queries to activities that have not passed.
     *
     * @var query
     */
    public function scopeUpcoming($query)
    {
        $query->where('datetime_start', '>', Carbon::now()->endOfDay())->oldest('datetime_start');
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

        if ($taskCount == 0) {
            return "Not Started";
        } else {
            $groupByStatus = $tasks->groupBy('status');
            $groupByApproval = $tasks->groupBy('approval');

            if ($groupByStatus->has('completed')) {
                return "Completed";
            } else if ($groupByStatus->has('picked-up') ||
                $groupByStatus->has('at check-up') ||
                $groupByStatus->has('check-up completed')
            ) {
                return "In-Progress";
            } else if ($groupByApproval->has('approved')) {
                return "Volunteer Approved";
            } else if ($groupByApproval->has('pending')) {
                return $groupByApproval->all()['pending']->count() . " Application(s) Received";
            } else if ($groupByApproval->has('withdrawn')) {
                return $groupByApproval->all()['withdrawn']->count() . " Application(s) Withdrawn";
            } else if ($groupByApproval->has('rejected')) {
                return $groupByApproval->all()['rejected']->count() . " Application(s) Rejected";
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
     * Set the activity's expected duration in minutes.
     */
    public function setExpectedDurationMinutesAttribute($duration)
    {
        $this->attributes['expected_duration_minutes'] = $duration * 60;
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
            ->withPivot('status', 'approval')
            ->withTimestamps();
    }
}
