<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * ElderlyLanguage class that interact with its corresponding table in the database.
 * This model allows for soft delete, where records are not actually deleted from the database.
 *
 * @package App
 */
class ElderlyLanguage extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'elderly_language';

    /**
     * The primary key in the database table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
    protected $fillable = ['elderly_id', 'language'];

    /**
     * Additional fields to be mutated to Carbon instances (date object).
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Set the language.
     *
     * @param  string  $language  the name of the language
     * @return void
     */
    public function setLanguageAttribute($language)
    {
        $this->attributes['language'] = ucwords(strtolower($language));
    }

    /**
     * Get the centre that the elderly belongs to.
     *
     * @return  \App\Elderly  the centre that the elderly belongs to.
     */
    public function elderly()
    {
        return $this->belongsTo('App\Elderly');
    }
}
