<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Staff class that interact with its corresponding table in the database.
 * This model allows for soft delete, where records are not actually deleted from the database.
 *
 * @package App
 */
class Staff extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'staff';

    /**
     * The primary key in the database table.
     *
     * @var string
     */
    protected $primaryKey = 'staff_id';

    /**
     * The attributes in the database table that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'is_admin'];

    /**
     * The attributes in the database table that are hidden for array.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Additional fields to be mutated to Carbon instances (date object).
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Scope a query to only include staff that are in charge of all centres that the specified staff are in charge of.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to staff to be scoped
     * @param  \App\Staff  $staff  the staff to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCentres($query, $staff)
    {
        $query->with('centres')
            ->select('staff.*')
            ->join('centre_staff', function ($join) {
                $join->on('staff.staff_id', '=', 'centre_staff.staff_id');
            })->whereIn('centre_staff.centre_id', $staff->centres->lists('centre_id'))
            ->distinct();
    }

    /**
     * Set the staff's name.
     *
     * @param  string  $name  the staff's name
     * @return void
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords(trim($name));
    }

    /**
     * Set the staff's email address.
     *
     * @param  string  $email  the staff's email address
     * @return void
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower(trim($email));
    }

    /**
     * Set the staff's admin role.
     *
     * @param  bool  $admin  TRUE, "1" or 1 if the staff is an administrator, FALSE, "0" or 0 otherwise.
     * @return void
     */
    public function setIsAdminAttribute($admin)
    {
        if($admin == "1" || $admin == 1 || $admin) {
            $this->attributes['is_admin'] = true;
        } else {
            $this->attributes['is_admin'] = false;
        }
    }

    /**
     * Get the centres that the staff are in charge of.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of centres that the staff are in charge of.
     */
    public function centres()
    {
        return $this->belongsToMany('App\Centre');
    }

    /**
     * Get the activities that belong to the centre.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of activities that belong the centre.
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }
}
