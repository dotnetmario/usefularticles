<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'authors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'name',
    ];


    /**
     * Relashions
     * 
     * 
     */

    /**
     * Get the articles for the author.
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
}
