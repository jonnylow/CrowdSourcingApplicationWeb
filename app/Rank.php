<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Rank class that interact with its corresponding table in the database.
 *
 * @package App
 */
class Rank extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ranks';

    /**
     * The primary key in the database table.
     *
     * @var string
     */
    protected $primaryKey = 'rank_id';

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
    protected $fillable = ['rank', 'name', 'min', 'max'];

    /**
     * Scope a query to only include ranks that needs the lowest min points.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  the query to ranks to be scoped
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLowest($query)
    {
        $query->where('min', '=', Rank::all()->min('min'));
    }

    /**
     * Get the volunteers that has the rank.
     *
     * @return  \Illuminate\Database\Eloquent\Collection  the collection of volunteers that has the rank.
     */
    public function volunteers()
    {
        return $this->belongsToMany('App\Volunteer');
    }
}
