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
     * Get the vwo users associated with the senior centre.
     */
    public function vwoUsers()
    {
        return $this->hasMany('App\VwoUser');
    }

    /**
     * Get the activities associated with the senior centre.
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }
}
