<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'article_id', 'user_id', 'characteristic_id',
    ];

    /**
     * Relations
     * 
     * 
     */

    /**
     * Get the article.
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the characteristic.
     */
    public function characteristic()
    {
        return $this->belongsTo('App\Characteristic');
    }
}
