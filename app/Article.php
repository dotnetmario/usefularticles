<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'publisher_id', 'author_id', 'title', 'description', 'article_url', 'image_url', 'publish_date',
    ];


    /**
     * Relashions
     * 
     * 
     */

    /**
     * Get the comments for the article.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the ratings for the article.
     */
    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    /**
     * Get the publisher that owns the article.
     */
    public function publisher()
    {
        return $this->belongsTo('App\Publisher');
    }

    /**
     * Get the author that owns the article.
     */
    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    /**
     * Get the score record associated with the article.
     */
    public function score()
    {
        return $this->hasOne('App\Score');
    }
}
