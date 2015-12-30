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
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'contact_no', 'address_1',
        'address_2', 'postal_code', 'description'];

    /**
     * Get the staff associated with the senior centre.
     */
    public function staff()
    {
        return $this->belongsToMany('App\Staff');
    }

    /**
     * Get the elderly associated with the senior centre.
     */
    public function elderly()
    {
        return $this->hasMany('App\Elderly');
    }

    /**
     * Get the activities associated with the senior centre.
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }
}
