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
    protected $fillable = ['nric', 'name', 'email', 'password', 'gender',
        'date_of_birth', 'contact_no', 'occupation', 'has_car', 'minutes_volunteered',
        'area_of_preference_1', 'area_of_preference_2', 'image_nric_front',
        'image_nric_back', 'is_approved', 'rank_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'image_nric_front', 'image_nric_back'];

    /**
     * Additional fields to treat as Carbon instances (date object).
     *
     * @var array
     */
    protected $dates = ['date_of_birth'];

    /**
     * Set the nric attribute.
     *
     * @var nric
     */
    public function setNricAttribute($nric)
    {
        $this->attributes['nric'] = strtoupper($nric);
    }

    /**
     * Set the name attribute.
     *
     * @var name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords(trim($name));
    }

    /**
     * Set the email attribute.
     *
     * @var email
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = trim($email);
    }

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
     * Set the gender attribute.
     *
     * @var gender
     */
    public function setGenderAttribute($gender)
    {
        $this->attributes['gender'] = strtoupper($gender);
    }

    /**
     * Set if the volunteer has car.
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
     * Get the volunteer's rank points.
     *
     * @return int
     */
    public function rankPoints()
    {
        // 1 point for every 60 minutes volunteered
        // Truncate extra decimal points
        return intval($this->minutes_volunteered / 60);
    }

    /**
     * Get the volunteer's volunteered time.
     *
     * @return string
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
     * @return integer
     */
    public function numOfCompletedActivity()
    {
        return $this->tasks->where('status', 'completed')->count();
    }

    /**
     * Get the volunteer's withdrawn activity application count.
     *
     * @return integer
     */
    public function numOfWithdrawnActivity()
    {
        return $this->tasks->where('approval', 'withdrawn')->count();
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
     * Get the rank that the volunteer is at.
     */
    public function rank()
    {
        return $this->belongsTo('App\Rank');
    }

    /**
     * The task application that is associated with the volunteer.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * The activities that the volunteer has registered for.
     */
    public function activities()
    {
        return $this->belongsToMany('App\Activity', 'tasks', 'volunteer_id', 'activity_id')
            ->withPivot('status', 'approval', 'comment')
            ->withTimestamps();
    }
}
