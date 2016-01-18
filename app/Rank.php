<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ranks';
    protected $primaryKey = 'rank_id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rank', 'name', 'min', 'max'];

    /**
     * Scope queries to rank that is the lowest.
     *
     * @var $query
     */
    public function scopeLowest($query)
    {
        $query->where('min', '=', Rank::all()->min('min'));
    }

    /**
     * Get the volunteers that has this rank.
     */
    public function volunteers()
    {
        return $this->belongsToMany('App\Volunteer');
    }
}
