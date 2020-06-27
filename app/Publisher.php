<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'publishers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'name', 'website',
    ];


    /**
     * Relations
     * 
     * 
     */

    
    /**
     * Get the ratings of the characteristic.
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
}
