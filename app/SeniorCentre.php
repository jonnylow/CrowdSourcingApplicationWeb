<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeniorCentre extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'senior_centres';
    protected $primaryKey = 'senior_centre_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'contact_no', 'address_1', 'address_2', 'postal_code', 'description'];

    /**
     * Get the vwo user associated with the senior centre.
     */
    public function vwoUser()
    {
        return $this->hasMany('App\VwoUser');
    }

    /**
     * Get the activity associated with the senior centre.
     */
    public function activity()
    {
        return $this->hasMany('App\Activity');
    }
}
