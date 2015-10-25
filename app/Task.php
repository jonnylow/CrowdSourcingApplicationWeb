<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['registered_at', 'status', 'approval'];

    /**
     * Scope queries to tasks that belongs to a particular activity.
     *
     * @var $query
     * @var $activity
     */
    public function scopeOfActivity($query, $activity)
    {
        $query->where('activity_id', $activity->activity_id);
    }

    /**
     * Get the activity that owns the task.
     */
    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    /**
     * Get the volunteer that owns the task.
     */
    public function volunteer()
    {
        return $this->belongsTo('App\Volunteer');
    }
}
