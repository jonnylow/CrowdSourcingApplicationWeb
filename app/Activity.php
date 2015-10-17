<?php

namespace App;

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
     * Get the task associated with the activity.
     */
    public function task()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * The volunteer that belong to the activity.
     */
    public function activity()
    {
        return $this->belongsToMany('App\Volunteer', 'tasks', 'activity_id', 'volunteer_id')->withPivot('status', 'approval', 'registered_at');
    }
}
