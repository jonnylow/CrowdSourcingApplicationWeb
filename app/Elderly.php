<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elderly extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'elderly';
    protected $primaryKey = 'elderly_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nric', 'name', 'gender', 'next_of_kin_name',
        'next_of_kin_contact', 'medical_condition', 'image_photo', 'senior_centre_id'];

    /**
     * Scope queries to elderly that belongs to a senior centre.
     *
     * @var $query
     * @var $seniorCentreId
     */
    public function scopeOfSeniorCentre($query, $seniorCentreId)
    {
        $query->where('senior_centre_id', $seniorCentreId);
    }

    /**
     * Get a list of elderly's nric and name.
     *
     * @return array
     */
    public function getElderlyListAttribute()
    {
        return $this->attributes['nric'] . ' - ' . $this->attributes['name'];
    }

    /**
     * Get the senior centre that the elderly belongs to.
     */
    public function seniorCentre()
    {
        return $this->belongsTo('App\SeniorCentre');
    }

    /**
     * Get the activities associated with the elderly.
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    /**
     * Get the languages that the elderly knows.
     */
    public function languages()
    {
        return $this->hasMany('App\ElderlyLanguage');
    }
}
