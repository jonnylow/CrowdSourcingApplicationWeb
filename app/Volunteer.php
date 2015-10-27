<?php

namespace App;

use Carbon\Carbon;
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
     * Additional fields to treat as Carbon instances (date object).
     *
     * @var array
     */
    protected $dates = ['date_of_birth'];

    /**
     * Set the password attribute.
     *
     * @var password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Get the volunteer's gender.
     *
     * @param  $gender
     *
     * @return string
     */
    public function getGenderAttribute($gender)
    {
        switch (strtoupper($gender)) {
            case 'M':
                return 'Male';
            case 'F':
                return 'Female';
        }
    }

    /**
     * Get the volunteer's volunteered hours.
     *
     * @param  $minute
     *
     * @return string
     */
    public function getMinutesVolunteeredAttribute($minute)
    {
        $hours = floor($minute / 60);
        $minutes = ($minute % 60);
        return sprintf('%0d hour, %0d min', $hours, $minutes);
    }

    /**
     * Get the volunteer's age.
     *
     * @return string
     */
    public function age()
    {
        return $this->date_of_birth->diff(Carbon::now())->y;
    }

    /**
     * Get the tasks associated with the volunteer.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * The activities that belong to the volunteer.
     */
    public function activities()
    {
        return $this->belongsToMany('App\Activity', 'tasks', 'volunteer_id', 'activity_id')->withPivot('status', 'approval', 'created_at');
    }
}
