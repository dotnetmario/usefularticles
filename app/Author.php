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
     * pivot table named article_author
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }


    /**
     * 
     * querying
     * 
     * 
     */

    /**
     * exists
     * 
     * @param string name
     * 
     * @return bool
     */
    public function exists($name){
        return Author::where('name', $name)->count() > 0;
    }

    /**
     * get author
     * 
     * @param int id
     * @param string name
     * 
     * @return Author
     */
    public function getAuthor($id, $name = null){
        $col = 'id';
        $val = $id;

        if(isset($name) && $name){
            $col = 'name';
            $val = $name;
        }

        return Author::where($col, $val)->first();
    }

    /**
     * add nn author
     * 
     * @param string name
     * 
     * @return Author
     */
    public function add($name){
        return Author::create([
            'name' => $name
        ]);
    }



}
