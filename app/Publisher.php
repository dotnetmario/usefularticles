<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use SoftDeletes;

    public $_api_id;
    public $_name;
    public $_website;
    public $_description;
    public $_category;
    public $_lang;
    public $_country;

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
        'api_id', 'name', 'website', 'description', 'category', 'lang', 'country'
    ];

    /**
     * Constructor
     * 
     */
    public function __construct($api_id = null, $name = null, $website = null, $description = null, $category = null, $lang = null, $country = null){
        $this->_api_id = $api_id;
        $this->_name = $name;
        $this->_website = $website;
        $this->_description = $description;
        $this->_category = $category;
        $this->_lang = $lang;
        $this->_country = $country;
    }


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

    /**
     * querying
     * 
     * 
     * 
     */

    /**
     * test if a publisher exists
     * 
     * 
     * @return bool
     */
    public function exists(){
        $pub = new Publisher;

        if(isset($this->_api_id) && $this->_api_id){
            $col = 'api_id';
            $val = $this->_api_id;
            $pub = $pub->where($col, $val);
        }

        if(isset($this->_name) && $this->_name){
            $col = 'name';
            $val = $this->_name;
            $pub = $pub->where($col, $val);
        }

        if(isset($this->_website) && $this->_website){
            $col = 'website';
            $val = $this->_website;
            $pub = $pub->where($col, $val);
        }

        return $pub->count() > 0;
    }

    /**
     * get a publisher
     * 
     * @param int id
     * @return Pubisher
     */
    public function getPublisher($id = null){
        $pub = new Publisher;

        if(isset($id) && $id){
            $pub = $pub->find($id);
            return $pub;
        }

        if(isset($this->_api_id) && $this->_api_id){
            $col = 'api_id';
            $val = $this->_api_id;
            $pub = $pub->where($col, $val);
        }

        if(isset($this->_name) && $this->_name){
            $col = 'name';
            $val = $this->_name;
            $pub = $pub->where($col, $val);
        }

        if(isset($this->_website) && $this->_website){
            $col = 'website';
            $val = $this->_website;
            $pub = $pub->where($col, $val);
        }

        return $pub->first();
    }

    /**
     * get publisher with an approximate name
     * 
     * 
     * @return Collection publisher
     */
    public function getApproximateName(){
        $name = $this->_name;
        
        return Publisher::where('name', 'like', '% '.$name.' %')
                ->orWhere('name', 'like', '%'.$name.' %')
                ->orWhere('name', 'like', '% '.$name.'%')
                ->get();
    }

    /**
     * add a publisher
     * 
     * 
     * @return Publisher
     */
    public function add(){
        $pub = new Publisher;

        $pub->name = $this->_name;
        $pub->api_id = $this->_api_id;
        $pub->website = $this->_website;
        $pub->description = $this->_description;
        $pub->category = $this->_category;
        $pub->lang = $this->_lang;
        $pub->country = $this->_country;

        $pub->save();

        return $pub;
    }

    /**
     * delete a publisher
     * 
     * @param int id
     * 
     * @return Publisher
     */
    public function remove($id){
        return Publisher::where('id', $id)->delete();
    }
}
