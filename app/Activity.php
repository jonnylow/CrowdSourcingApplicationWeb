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
    protected $fillable = ['location_from', 'location_from_address',
        'location_from_long', 'location_from_lat', 'location_to',
        'location_to_address', 'location_to_long', 'location_to_lat',
        'datetime_start', 'expected_duration_minutes', 'more_information',
        'category', 'elderly_id', 'senior_centre_id', 'staff_id'];

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
     * Scope queries to activities that belongs to all senior centres associated with the staff.
     *
     * @var $query
     * @var $staff
     */
    public function scopeOfSeniorCentreForStaff($query, $staff)
    {
        $query->whereIn('senior_centre_id', $staff->seniorCentres->lists('senior_centre_id'));
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
     * Set the activity's start location address.
     */
    public function setLocationFromAddress($location)
    {
        $this->attributes['location_from'] = ucwords(strtolower($location));
    }

    /**
     * Set the activity's end  address.
     */
    public function setLocationToAddress($location)
    {
        $this->attributes['location_to'] = ucwords(strtolower($location));
    }

    /**
     * Get the elderly associated with the activity.
     */
    public function elderly()
    {
        return $this->belongsTo('App\Elderly');
    }

    /**
     * Get the senior centre that the activity belongs to.
     */
    public function seniorCentre()
    {
        return $this->belongsTo('App\SeniorCentre');
    }

    /**
     * Get the staff that created the activity.
     */
    public function staff()
    {
        return $this->belongsTo('App\Staff');
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
