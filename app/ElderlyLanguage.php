<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElderlyLanguage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'elderly_language';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['elderly_id', 'language'];

    /**
     * Get the elderly whom the 'language row' belongs to.
     */
    public function elderly()
    {
        return $this->belongsTo('App\Elderly');
    }
}
