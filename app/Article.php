<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helper;

class Article extends Model
{
    use SoftDeletes;

    public $_pub_id;
    public $_permalink;
    public $_title;
    public $_desc;
    public $_url;
    public $_image;
    public $_p_date;

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
        'publisher_id', 'permalink', 'title', 'description', 'article_url', 'image_url', 'publish_date',
    ];

    /**
     * construct
     * 
     * 
     */
    public function __construct($pub_id = null, $title = null, $desc = null, $url = null, $image = null, $p_date = null){
        $this->_pub_id = $pub_id;
        $this->_title = $title;
        $this->_desc = $desc;
        $this->_url = $url;
        $this->_image = $image;
        $this->_p_date = $p_date;
    }


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
     * Get the author or authors that owns the article.
     * pivot table named article_author
     */
    public function authors()
    {
        return $this->belongsToMany('App\Author');

        // syntax to return the pivot table columns
        // ->withPivot('products_amount', 'price')
        // ->withTimestamps();

        // example for calling pivot table culumns
        // echo $product->pivot->price;

        // example for setting pivot table columns with custom values
        // $shop->products()->attach(1, ['products_amount' => 100, 'price' => 49.99])
        // or $shop->products()->attach(1 (or array of values)) without the custom columns

        // example to remove pivot columns
        // $shop->products()->attach([123, 456, 789] (or a single id));

        // example to remove and populate with only given values
        // $product->shops()->sync([1, 2, 3]);
    }

    /**
     * Get the score record associated with the article.
     */
    public function score()
    {
        return $this->hasOne('App\Score');
    }


    /**
     * querying
     * 
     * 
     * 
     */
    


    /**
     * test if an article exists
     * 
     * @param string col
     * @param string val
     * 
     * @return bool
     */
    public function exists($val, $col = "article_url"){
        return Article::where($col, $val)->count() > 0;
    }

    /**
     * make a permalink
     * 
     * @param string title
     * 
     * @return string
     */
    public function generatePermalink($title = null){
        $t = "";
        if(!isset($this->_title) && !isset($title))
            return null;

        if(!isset($this->_title))
            $t = $title;
        else
            $t = $this->_title;

        $this->_permalink = preg_replace('/[^\p{L}\p{N}\s]/u', '', $t);
        $this->_permalink = str_replace(' ', '-', $this->_permalink);
        $str = md5(time());
        $this->_permalink .= '-'.substr($str, (int)rand(1, 10), strlen($str) > 30 ? 15 : null);

        return $this->_permalink;
    }

    /**
     * add an article
     * 
     * @param int|array author_id
     * 
     * @return int article id
     */
    public function add($auth_id){
        if(!isset($auth_id))
            return null;
    
        $art = new Article;
        $art->publisher_id = $this->_pub_id;
        $art->permalink = $this->generatePermalink();
        $art->title = $this->_title;
        $art->description = $this->_desc;
        $art->article_url = $this->_url;
        $art->image_url = $this->_image;
        $art->publish_date = $this->_p_date;
        
        if($art->save()){
            $art = (new Article)->find($art->id);
            $art->authors()->attach($auth_id);
        }

        return $art;
    }


    /**
     * querying 
     * 
     * 
     * 
     */

    /**
     * get the articles
     * 
     * @param string type (most-viewed, most-engaging, top-scorer, recent)
     * @param string from
     * @param string to
     * @param int artsPerPage (for pagination)
     * 
     * @return Collection
     */
    public function getArticles(
        $type = 'recent',
        $from = null,
        $to = null,
        $artsPerPage = 20
    ){
        $res = new Article;

        switch ($type) {
            case 'recent':
                $res = $res->orderBy('publish_date', 'DESC');
                break;
            
            default:
                break;
        }

        // for dates
        if(isset($from)){
            if(!isset($to))
                $to = date('Y-m-d');

            $ans = Helper::validateDate($from, 'Y-m-d') && Helper::validateDate($to, 'Y-m-d');

            if($ans){
                $res = $res->where('publish_date', '>=', $from)
                            ->where('publish_date', '<=', $to);
            }
        }

        return $res->paginate($artsPerPage);
    }
}
