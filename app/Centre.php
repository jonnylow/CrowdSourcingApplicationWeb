<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centre extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'centres';
    protected $primaryKey = 'centre_id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'postal_code',
        'lng', 'lat'];

    /**
     * Get the staff associated with the centre.
     */
    public function staff()
    {
        return $this->belongsToMany('App\Staff');
    }

    /**
     * Get the elderly associated with the centre.
     */
    public function elderly()
    {
        return $this->hasMany('App\Elderly');
    }

    /**
     * Get the activities associated with the centre.
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    /**
     * Get the activities that will arrive at the centre.
     */
    public function arrivalActivities()
    {
        return $this->hasMany('App\Activity', 'location_to_id');
    }

    /**
     * Get the activities that will start at the centre.
     */
    public function departureActivities()
    {
        return $this->hasMany('App\Activity', 'location_from_id');
    }
}
