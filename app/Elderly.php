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
    protected $fillable = ['nric', 'name', 'gender', 'date_of_birth', 'next_of_kin_name',
        'next_of_kin_contact', 'medical_condition', 'image_photo', 'centre_id'];

    /**
     * Scope queries to elderly that belongs to all centres associated with the staff.
     *
     * @var $query
     * @var $staff
     */
    public function scopeOfCentreForStaff($query, $staff)
    {
        $query->whereIn('centre_id', $staff->centres->lists('centre_id'));
    }

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
     * Set the next_of_kin_name attribute.
     *
     * @var nokName
     */
    public function setNextOfKinNameAttribute($nokName)
    {
        $this->attributes['next_of_kin_name'] = ucwords(trim($nokName));
    }

    /**
     * Get the elderly's gender.
     *
     * @param  $gender
     *
     * @return string
     */
    public function getGenderAttribute($gender)
    {
        switch (strtoupper($gender)) {
            case 'M':
                return 'Male';
            case 'F':
                return 'Female';
        }
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
     * Get the centre that the elderly belongs to.
     */
    public function centre()
    {
        return $this->belongsTo('App\Centre');
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
