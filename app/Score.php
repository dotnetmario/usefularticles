<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'scores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'article_id',
    ];

    /**
     * Relations
     * 
     * 
     */

    /**
     * Get the score original article.
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
