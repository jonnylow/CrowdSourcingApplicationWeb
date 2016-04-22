<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Elderly class that interact with its corresponding table in the database.
 * This model allows for soft delete, where records are not actually deleted from the database.
 *
 * @package App
 */
class Elderly extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'elderly';

    /**
     * The primary key in the database table.
     *
     * @var string
     */
    protected $primaryKey = 'elderly_id';

    /**
     * The attributes in the database table that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nric', 'name', 'gender', 'birth_year', 'next_of_kin_name',
        'next_of_kin_contact', 'medical_condition', 'centre_id'];

    /**
     * Additional fields to be mutated to Carbon instances (date object).
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /*
     * Overwrite the boot function in Eloquent Model to listen for deletion/restoration events so as to
     * delete/restore all associated activities and languages when an elderly profile is deleted/restored.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();

        Elderly::deleting(function($elderly) {
            foreach(['activities', 'languages'] as $relation) {
                foreach($elderly->{$relation} as $item) {
                    $item->delete();
                }
            }
        });

        Elderly::restored(function($elderly) {
            foreach(['activities', 'languages'] as $relation) {
                foreach($elderly->{$relation} as $item) {
                    $item->restore();
                }
            }
        });
    }

    /**
     * Scope a query to only include elderly that belongs to all centres that the specified staff are in charge of.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to elderly to be scoped
     * @param  \App\Staff  $staff  the staff to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCentreForStaff($query, $staff)
    {
        $query->whereIn('centre_id', $staff->centres->lists('centre_id'));
    }

    /**
     * Set the elderly's NRIC number.
     *
     * @param  string  $nric  the elderly's NRIC number
     * @return void
     */
    public function setNricAttribute($nric)
    {
        $this->attributes['nric'] = strtoupper($nric);
    }

    /**
     * Set the elderly's name.
     *
     * @param  string  $name  the elderly's name
     * @return void
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords(trim($name));
    }

    /**
     * Set the elderly's gender.
     *
     * @param  string  $gender  "M" if the elderly is a male, "F" if otherwise
     * @return  void
     */
    public function setGenderAttribute($gender)
    {
        $this->attributes['gender'] = strtoupper($gender);
    }

    /**
     * Set the elderly's next-of-kin name.
     *
     * @param  string  $nokName  the elderly's next-of-kin name
     * @return void
     */
    public function setNextOfKinNameAttribute($nokName)
    {
        $this->attributes['next_of_kin_name'] = ucwords(trim($nokName));
    }

    /**
     * Get the elderly's name and NRIC number.
     *
     * @return  string  the elderly's name and NRIC number
     */
    public function getElderlyListAttribute()
    {
        return $this->attributes['name'] . ' - ' . $this->attributes['nric'];
    }

    /**
     * Get the elderly's age.
     *
     * @return  int  the elderly's age
     */
    public function age()
    {
        return (Carbon::now()->year - $this->birth_year);
    }

    /**
     * Get the centre that the elderly belongs to.
     *
     * @return  \App\Centre  the centre that the elderly belongs to.
     */
    public function centre()
    {
        return $this->belongsTo('App\Centre');
    }

    /**
     * Get the activities that are associated with the elderly.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of activities that are associated with the elderly.
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    /**
     * Get the languages that are spoken by the elderly.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of languages that are spoken by the elderly.
     */
    public function languages()
    {
        return $this->hasMany('App\ElderlyLanguage');
    }
}
