<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'replies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'comment_id', 'user_id', 'body', 'mention',
    ];

    /**
     * Relations
     * 
     * 
     */

    /**
     * Get the reply original comment.
     */
    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }

    /**
     * Get the user that made the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
