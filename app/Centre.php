<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Centre class that interact with its corresponding table in the database.
 *
 * @package App
 */
class Centre extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'centres';

    /**
     * The primary key in the database table.
     *
     * @var string
     */
    protected $primaryKey = 'centre_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes in the database table that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'postal_code',
        'lng', 'lat'];

    /**
     * Set the centre's name.
     *
     * @param  string  $name  the name of the centre
     * @return void
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords(strtolower($name));
    }

    /**
     * Get the staff that are in charge the centre.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of staff that are in charge of the centre.
     */
    public function staff()
    {
        return $this->belongsToMany('App\Staff');
    }

    /**
     * Get the elderly that belong to the centre.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of elderly that belong to the centre.
     */
    public function elderly()
    {
        return $this->hasMany('App\Elderly');
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

    /**
     * Get the activities that will end at the centre.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of activities that will end at the centre.
     */
    public function arrivalActivities()
    {
        return $this->hasMany('App\Activity', 'location_to_id');
    }

    /**
     * Get the activities that will start at the centre.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of activities that will start at the centre.
     */
    public function departureActivities()
    {
        return $this->hasMany('App\Activity', 'location_from_id');
    }
}
