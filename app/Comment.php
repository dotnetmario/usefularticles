<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Article;
use App\Helper;

class Comment extends Model
{
    use SoftDeletes;

    public $_article_id;
    public $_user_id;
    public $_body;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'article_id', 'user_id', 'body', 'mention',
    ];

    /**
     * construct
     * 
     */
    public function __construct($article = null, $user = null, $body = null){
        $this->_article_id = $article;
        $this->_user_id = $user;
        $this->_body = $body;
    }

    /**
     * Relations
     * 
     * 
     */

    /**
     * Get the comment original article.
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    /**
     * Get the user that made the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the comment replies.
     */
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    /**
     * utilities
     * 
     */
    public function exists($id){
        if(!isset($id))
            return false;

        return Comment::where('id', $id)->count() > 0;
    }


    /**
     * 
     * CRUD
     */

    /**
     * comments on an article
     * 
     * @param int user
     * @param int|string article
     * @param string body
     * 
     * @return Comment
     */
    public function commentOnArticle($user = null, $article = null, $body = null){
        $user = $this->_user_id ?? $user;
        $article = $this->_article_id ?? $article;
        $body = $this->_body ?? $body;

        // cast article to it's original form
        $article = Helper::getRealVariableValue($article);

        if(!isset($user) || !isset($article) || !isset($body))
            return null;

        if(gettype($article) === "string")
            $article = (new Article)->getArticle($article)->id;

        $com = new Comment;

        $com->user_id = $user;
        $com->article_id = $article;
        $com->body = $body;

        $com->save();

        return $com;
    }
}
