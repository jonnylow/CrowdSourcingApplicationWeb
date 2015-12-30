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
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['activity_id', 'volunteer_id', 'status', 'approval'];

    /**
     * Scope queries to tasks that belongs to a particular activity.
     *
     * @var $query
     * @var $activityId
     */
    public function scopeOfActivity($query, $activityId)
    {
        $query->where('activity_id', $activityId);
    }

    /**
     * Set the approval attribute.
     *
     * @var approval
     */
    public function setApprovalAttribute($approval)
    {
        $this->attributes['approval'] = strtolower($approval);
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
