<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;

    public $_comment_id;
    public $_user_id;
    public $_body;
    public $_mention;

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

    public function __construct($comment = null, $user = null, $body = null, $mention = null){
        $this->_comment_id = $comment;
        $this->_user_id = $user;
        $this->_body = $body;
        $this->_mention = $mention;
    }

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

    /**
     * CRUD
     * 
     * 
     */

    /**
     * add a reply to a comment
     * 
     * @param int comment
     * @param int user
     * @param string body
     * @param string mention
     * 
     * @return Reply
     */
    public function replyToComment($comment = null, $user = null, $body = null, $mention = null){
        // priority to function params
        $comment = $comment ?? $this->_comment_id;
        $user = $user ?? $this->_user_id;
        $body = $body ?? $this->_body;
        $mention = $mention ?? $this->_mention;

        if(!isset($comment) || !isset($user) || !isset($body))
            return false;


        $reply = new Reply;
        $reply->comment_id = $comment;
        $reply->user_id = $user;
        $reply->body = $body;
        $reply->mention = $mention;

        $reply->save();

        return $reply;
    }
}