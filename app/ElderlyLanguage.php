<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElderlyLanguage extends Model
{
    use SoftDeletes;

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
     * Additional fields to treat as Carbon instances (date object).
     */
    protected $dates = ['deleted_at'];

    /**
     * Set the language.
     */
    public function setLanguageAttribute($language)
    {
        $this->attributes['language'] = ucwords(strtolower($language));
    }

    /**
     * Get the elderly whom the 'language row' belongs to.
     */
    public function elderly()
    {
        return $this->belongsTo('App\Elderly');
    }
}
