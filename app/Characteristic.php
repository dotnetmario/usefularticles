<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Characteristic extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'characteristics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'characteristic',
    ];


    /**
     * Relations
     * 
     * 
     */

    
    /**
     * Get the ratings of the characteristic.
     */
    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }
}
