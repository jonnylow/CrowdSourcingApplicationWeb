<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Carbon\Carbon;

/**
 * Volunteer class that interact with its corresponding table in the database.
 *
 * @package App
 */
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

    /**
     * The primary key in the database table.
     *
     * @var string
     */
    protected $primaryKey = 'volunteer_id';

    /**
     * The attributes in the database table that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'gender', 'date_of_birth',
        'contact_no', 'occupation', 'has_car', 'minutes_volunteered',
        'area_of_preference_1', 'area_of_preference_2', 'is_approved', 'rank_id'];

    /**
     * The attributes in the database table that are hidden for array.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * Additional fields to be mutated to Carbon instances (date object).
     *
     * @var array
     */
    protected $dates = ['date_of_birth'];

    /**
     * Set the volunteer's name.
     *
     * @param  string  $name  the volunteer's name
     * @return void
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords(trim($name));
    }

    /**
     * Set the volunteer's email address.
     *
     * @param  string  $email  the volunteer's email address
     * @return void
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower(trim($email));
    }

    /**
     * Set the volunteer's password.
     *
     * @param  string  $password  the volunteer's password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Set the volunteer's gender.
     *
     * @param  string  $gender  "M" if the volunteer is a male, "F" if otherwise
     * @return void
     */
    public function setGenderAttribute($gender)
    {
        $this->attributes['gender'] = strtoupper($gender);
    }

    /**
     * Set the volunteer's occupation.
     *
     * @param  string  $occupation  the volunteer's occupation, occupation will be set to NULL if blank string is passed.
     * @return void
     */
    public function setOccupationAttribute($occupation)
    {
        $this->attributes['occupation'] = ucwords(trim($occupation)) != '' ? $occupation : null;
    }

    /**
     * Set if the volunteer has car.
     *
     * @param  bool  $car  TRUE, "1" or 1 if the volunteer has a car, FALSE, "0" or 0 otherwise.
     * @return void
     */
    public function setHasCarAttribute($car)
    {
        if($car == "1" || $car == 1 || $car) {
            $this->attributes['has_car'] = true;
        } else {
            $this->attributes['has_car'] = false;
        }
    }

    /**
     * Set the volunteer's first volunteering preference.
     *
     * @param  string  $area  the volunteer's preference, preference will be set to NULL if blank string is passed.
     * @return void
     */
    public function setAreaOfPreference1Attribute($area)
    {
        $this->attributes['area_of_preference_1'] = ucfirst(trim($area)) != '' ? $area : null;
    }

    /**
     * Set the volunteer's second volunteering preference.
     *
     * @param  string  $area  the volunteer's preference, preference will be set to NULL if blank string is passed.
     * @return void
     */
    public function setAreaOfPreference2Attribute($area)
    {
        $this->attributes['area_of_preference_2'] = ucfirst(trim($area)) != '' ? $area : null;
    }

    /**
     * Get the volunteer's rank points.
     *
     * @return  int  the volunteer's rank points.
     */
    public function rankPoints()
    {
        // 1 point for every 60 minutes volunteered
        // Truncate extra decimal points
        return intval($this->minutes_volunteered / 60);
    }

    /**
     * Get the volunteer's volunteered time in textual form.
     *
     * @return  string  the volunteer's volunteered time.
     */
    public function timeVolunteered()
    {
        $time = $this->minutes_volunteered;

        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf('%0d hour, %0d min', $hours, $minutes);
    }

    /**
     * Get the volunteer's completed activities count.
     *
     * @return  int  the number of completed activities for the volunteer.
     */
    public function numOfCompletedActivity()
    {
        return $this->tasks->where('status', 'completed')->count();
    }

    /**
     * Get the volunteer's withdrawn activity application count.
     *
     * @return  int  the number of withdrawn activity application for the volunteer.
     */
    public function numOfWithdrawnActivity()
    {
        return $this->tasks->where('approval', 'withdrawn')->count();
    }

    /**
     * Get the volunteer's age.
     *
     * @return  int  the volunteer's age.
     */
    public function age()
    {
        return $this->date_of_birth->diff(Carbon::now())->y;
    }

    /**
     * Get the rank of the volunteer.
     *
     * @return  \App\Rank  the rank of the volunteer.
     */
    public function rank()
    {
        return $this->belongsTo('App\Rank');
    }

    /**
     * Get the task applications that are associated with the volunteer.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of task applications that are associated with the volunteer.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * Get the activities that are associated with the volunteer.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of activities that are associated with the volunteer.
     */
    public function activities()
    {
        return $this->belongsToMany('App\Activity', 'tasks', 'volunteer_id', 'activity_id')
            ->withPivot('status', 'approval', 'comment')
            ->withTimestamps();
    }
}
