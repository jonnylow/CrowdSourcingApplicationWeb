<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Volunteer extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteers';
    protected $primaryKey = 'volunteer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nric', 'name', 'email', 'password', 'gender', 'date_of_birth',
        'contact_no', 'occupation', 'has_car', 'minutes_volunteered', 'area_of_preference_1',
        'area_of_preference_2', 'image_nric_front', 'image_nric_back', 'is_approved'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * Get the task associated with the volunteer.
     */
    public function task()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * The activity that belong to the volunteer.
     */
    public function activity()
    {
        return $this->belongsToMany('App\Activity', 'tasks', 'volunteer_id', 'activity_id')->withPivot('status', 'approval', 'registered_at');
    }
}
