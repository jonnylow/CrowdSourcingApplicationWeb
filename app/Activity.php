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
    protected $fillable = ['name', 'location_from', 'location_from_long', 'location_from_lat', 'location_to',
        'location_to_long', 'location_to_lat', 'datetime_start', 'expected_duration_minutes', 'more_information',
        'elderly_name', 'next_of_kin_name', 'next_of_kin_contact', 'senior_centre_id', 'vwo_user_id'];

    /**
     * Additional fields to treat as Carbon instances (date object).
     *
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
        $query->where('datetime_start', '<', Carbon::now())->latest('datetime_start');
    }

    /**
     * Scope queries to activities that starts today.
     *
     * @var query
     */
    public function scopeToday($query)
    {
        $query->where('datetime_start', '=', Carbon::now())->oldest('datetime_start');
    }

    /**
     * Scope queries to activities that have not passed.
     *
     * @var query
     */
    public function scopeUpcoming($query)
    {
        $query->where('datetime_start', '>', Carbon::now())->oldest('datetime_start');
    }

    /**
     * Scope queries to activities that belongs to a particular senior centre.
     *
     * @var $query
     * @var $seniorCentreId
     */
    public function scopeOfSeniorCentre($query, $seniorCentreId)
    {
        $query->where('senior_centre_id', $seniorCentreId);
    }

    /**
     * Set the activity's starting date and time.
     */
    public function setDateTimeStartAttribute($datetime)
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
     * Set the activity's start location.
     */
    public function setLocationFrom($location)
    {
        $this->attributes['location_from'] = ucwords(strtolower($location));
    }

    /**
     * Set the activity's end location.
     */
    public function setLocationTo($location)
    {
        $this->attributes['location_to'] = ucwords(strtolower($location));
    }

    /**
     * Get the senior centre that the vwo user belongs to.
     */
    public function seniorCentre()
    {
        return $this->belongsTo('App\SeniorCentre');
    }

    /**
     * Get the vwo user that owns the activity.
     */
    public function vwoUser()
    {
        return $this->belongsTo('App\VwoUser');
    }

    /**
     * Get the tasks associated with the activity.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * The volunteers that belong to the activity.
     */
    public function volunteers()
    {
        return $this->belongsToMany('App\Volunteer', 'tasks', 'activity_id', 'volunteer_id')->withPivot('status', 'approval', 'registered_at');
    }
}
