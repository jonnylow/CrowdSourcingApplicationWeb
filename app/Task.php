<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Task class that interact with its corresponding table in the database.
 * This model allows for soft delete, where records are not actually deleted from the database.
 *
 * @package App
 */
class Task extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The primary key in the database table.
     *
     * @var string
     */
    protected $primaryKey = 'task_id';

    /**
     * The attributes in the database table that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['volunteer_id', 'activity_id', 'status', 'approval', 'comment'];

    /**
     * Additional fields to be mutated to Carbon instances (date object).
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Scope a query to only include tasks that belongs to the activity specified.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to tasks to be scoped
     * @param  int  $activityId  the ID of the activity
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfActivity($query, $activityId)
    {
        $query->where('activity_id', $activityId);
    }

    /**
     * Set the task application's approval status.
     *
     * @param  string  $approval  "pending" if the application is new, "withdrawn" if the volunteer had withdrawn the application, "rejected" if the volunteer's application is rejected, "approved" if the volunteer's application is approved.
     * @return void
     */
    public function setApprovalAttribute($approval)
    {
        $this->attributes['approval'] = strtolower($approval);
    }

    /**
     * Get the activity that owns the task.
     *
     * @return  \App\Activity  the activity that owns the task.
     */
    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    /**
     * Get the volunteer that owns the task.
     *
     * @return  \App\Volunteer  the volunteer that owns the task.
     */
    public function volunteer()
    {
        return $this->belongsTo('App\Volunteer');
    }
}
