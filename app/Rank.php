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
    protected $fillable = ['name', 'points_required'];
}
