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
     * Get the volunteers that has this rank.
     */
    public function volunteers()
    {
        return $this->belongsToMany('App\Volunteer');
    }
}
