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
    protected $primaryKey = 'staff_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'is_admin'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Additional fields to treat as Carbon instances (date object).
     */
    protected $dates = ['deleted_at'];

    /**
     * Scope queries to staff that belongs to all centres associated with the staff.
     *
     * @var $query
     * @var $staff
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
     * Set the name attribute.
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
        $this->attributes['email'] = strtolower(trim($email));
    }

    /**
     * Set the staff admin privilege.
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
     * Get the centres that the staff is in charge of.
     */
    public function centres()
    {
        return $this->belongsToMany('App\Centre');
    }

    /**
     * Get the activities created by the staff.
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }
}
