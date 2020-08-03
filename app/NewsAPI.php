<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use App\Publisher;
use App\Author;

class NewsAPI extends Model
{
    protected $_url;
    protected $_key;
    protected $_endPoints;
    protected $_countries;
    protected $_categories;
    protected $_languages;
    protected $_sorting;
    
    /**
     * construct
     * 
     */
    public function __construct(){
        $this->_url = config('apis.news_api')['url'];
        $this->_key = config('apis.news_api')['key'];
        $this->_endPoints = config('apis.news_api')['endpoints'];
        $this->_countries = config('apis.news_api')['countries'];
        $this->_categories = config('apis.news_api')['categories'];
        $this->_languages = config('apis.news_api')['languages'];
        $this->_sorting = config('apis.news_api')['sorting'];
    }

    /**
     * Build the url for the top headlines request end-point
     * 
     * @param string query
     * @param int artsPerPage
     * @param int page
     * @param string country
     * @param string category
     * @param string source
     * 
     * @return void
     */
    public function constructTopURL(
        $query = null,
        $artsPerPage = 20,
        $page = 1,
        $country = null,
        $category = null,
        $source = null
    ){
        $this->_url = config('apis.news_api')['url'];
        $this->_url .= $this->_endPoints['top'].'?1=1';

        // set the query
        if(isset($query) && $query){
            $this->_url .= "&q=$query";
        }

        // set the articles per page param
        if(isset($artsPerPage) && $artsPerPage){
            $this->_url .= "&pageSize=$artsPerPage";
        }

        // set the page param
        if(isset($page) && $page){
            $this->_url .= "&page=$page";
        }

        // set the source
        if(isset($source) && $source){
            $this->_url .= "&sources=$source";
        }

        // test if the source is set before adding country and category
        // they don't mix with the sources param
        if(!isset($source) && is_null($source)){
            // set the country
            if(isset($country) && $country && in_array($country, $this->_countries)){
                $this->_url .= "&country=$country";
            }

            // set the category
            if(isset($category) && $category && in_array($category, $this->_categories)){
                $this->_url .= "&category=$category";
            }
        }
    }

    /**
     * Build the url for the everything request end-point
     * 
     * @param string query
     * @param int artsPerPage
     * @param int page
     * @param string inTitle
     * @param string domain
     * @param string source
     * @param string exDomain
     * @param string from
     * @param string to
     * @param string lang
     * @param string sortBy
     * 
     * @return void
     */
    public function constructEverythingURL(
        $query = null,
        $artsPerPage = 20,
        $page = 1,
        $inTitle = null, // to search for in the article title only.
        $source = null, // comma-seperated string of identifiers (maximum 20) for the news sources or blogs you want headlines from.
        $domain = null, // A comma-seperated string of domains (eg bbc.co.uk, techcrunch.com, engadget.com) to restrict the search to.
        $exDomain = null, // A comma-seperated string of domains (eg bbc.co.uk, techcrunch.com, engadget.com) to remove from the results.
        $from = null, // date and optional time for the oldest article allowed in ISO 8601 format (e.g. 2020-07-04 or 2020-07-04T13:33:09)
        $to = null, // A date and optional time for the newest article allowed in ISO 8601 format (e.g. 2020-07-04 or 2020-07-04T13:33:09) 
        $lang = null,
        $sortBy = null
    ){
        $this->_url = config('apis.news_api')['url'];
        $this->_url .= $this->_endPoints['all'].'?'.'1=1';

        // keywords
        if(isset($query) && $query){
            $this->_url .= 'q='.urlencode($query);
        }

        // title keywords
        if(isset($inTitle) && $inTitle){
            $this->_url .= "&qInTitle=".urlencode($inTitle);
        }

        // set the sources param, comma separated string of sources limit is 20
        if(isset($source) && $source && count(explode(',', $source)) < 21){
            $this->_url .= "&sources=".$source;
        }

        // domains to get results from
        if(isset($domain) && $domain){
            $this->_url .= "&domains=".$domain;
        }

        // excluded domain to not get results from
        if(isset($exDomain) && $exDomain){
            $this->_url .= "&excludeDomains=".$exDomain;
        }

        // from
        if(isset($from) && $from){
            $this->_url .= "&from=".$from;
        }

        // from
        if(isset($to) && $to){
            $this->_url .= "&to=".$to;
        }

        // language if the results
        if(isset($lang) && $lang && in_array($lang, $this->_languages)){
            $this->_url .= "&language=".$lang;
        }

        // language if the results
        if(isset($sortBy) && $sortBy && in_array($sortBy, $this->_sorting)){
            $this->_url .= "&sortBy=".$sortBy;
        }

        // set the articles per page param
        if(isset($artsPerPage) && $artsPerPage){
            $this->_url .= "&pageSize=$artsPerPage";
        }

        // set the page param
        if(isset($page) && $page){
            $this->_url .= "&page=$page";
        }
    }

    /**
     * construct url for the sources endpoint
     * 
     * @param string category
     * @param string lang
     * @param string country
     * 
     * @return void
     */
    public function constructSourcesURL($cat = null, $lang = null, $country = null){
        $this->_url = config('apis.news_api')['url'];
        $this->_url .= $this->_endPoints['info'];

        if($cat == null && $lang == null && $country == null){
            return;
        }else{
            $this->_url .= '?1=1';
        }

        // set category
        if(isset($cat) && $cat && in_array($cat, $this->_categories)){
            $this->_url .= '&category='.$cat;
        }

        // set the lang
        if(isset($lang) && $lang && in_array($lang, $this->_languages)){
            $this->_url .= '&language='.$lang;
        }

        // set the country
        if(isset($country) && $country && in_array($country, $this->_categories)){
            $this->_url .= '&country='.$country;
        }
    }

    /**
     * Get the top headline articles from API
     * 
     * @param string query
     * @param int artsPerPage
     * @param int page
     * @param string country
     * @param string category
     * @param string source
     * 
     * @return string responce
     */
    public function getTopHeadlines(
        $query = null,
        $artsPerPage = 20,
        $page = 1,
        $country = null,
        $category = null,
        $source = null
    ){
        // set the X-Api-Key header
        $response = Http::withHeaders(['X-Api-Key' => $this->_key]);

        // construct the request url
        $this->constructTopURL($query, $artsPerPage, $page, $country, $category, $source);

        $response = $response->get($this->_url);

        return $response;
    }


    /**
     * search for articles for the everything request end-point
     * 
     * @param string query
     * @param int artsPerPage
     * @param int page
     * @param string inTitle
     * @param string domain
     * @param string source
     * @param string exDomain
     * @param string from
     * @param string to
     * @param string lang
     * @param string sortBy
     * 
     * @return void
     */
    public function getEverything(
        $query = null,
        $artsPerPage = 20,
        $page = 1,
        $inTitle = null, // to search for in the article title only.
        $source = null, // comma-seperated string of identifiers (maximum 20) for the news sources or blogs you want headlines from.
        $domain = null, // A comma-seperated string of domains (eg bbc.co.uk, techcrunch.com, engadget.com) to restrict the search to.
        $exDomain = null, // A comma-seperated string of domains (eg bbc.co.uk, techcrunch.com, engadget.com) to remove from the results.
        $from = null, // date and optional time for the oldest article allowed in ISO 8601 format (e.g. 2020-07-04 or 2020-07-04T13:33:09)
        $to = null, // A date and optional time for the newest article allowed in ISO 8601 format (e.g. 2020-07-04 or 2020-07-04T13:33:09) 
        $lang = null,
        $sortBy = null
    ){
        // set the X-Api-Key header
        $response = Http::withHeaders(['X-Api-Key' => $this->_key]);

        // construct the request url
        $this->constructEverythingURL($query, $artsPerPage, $page, $inTitle, $source, $domain, $exDomain, $from, $to, $lang, $sortBy);

        $response = $response->get($this->_url);

        return $response;
    }

    /**
     * search for news sources details and descriptions
     * 
     * @param string category
     * @param string lang
     * @param string country
     * 
     * @return HTTPResponse
     */
    public function getSources($cat = null, $lang = null, $country = null){
        // set the X-Api-Key header
        $response = Http::withHeaders(['X-Api-Key' => $this->_key]);

        // construct the request url
        $this->constructSourcesURL($cat, $lang, $country);

        $response = $response->get($this->_url);

        return $response;
    }

    /**
     * sanitize the author/authors of the article
     * for example an article can have multyple authors 
     * ex: (name1, name2)|(link)|(name | email)|(name, publisher)|(name, publisher + words)
     * 
     * @param string author
     * 
     * @return array[string] authors
     */
    public static function sanitizeAuthor($author){
        if(!isset($author) || $author == "")
            return false;
    
        $authors = array();

        // explode by 
        $aths = explode(',', $author);
        $aths_c = count($aths);

        foreach($aths as $ath){
            // check if the author is a link
            if(filter_var($ath, FILTER_VALIDATE_URL)){
                $a = explode('/', $ath);
                // take the last param as an author name
                $a = $a[count($a) - 1];
                array_push($authors, $a);
                continue;
            }

            // check if the author has some email or other data in his name
            $a = explode('|', $ath);
            if(count($a) > 1){
                array_push($authors, $a[0]);
                continue;
            }

            //check if publisher or publisher + words
            // if we have just one name even if it's the name of a publisher we use it as an author
            if($aths_c == 1){
                array_push($authors, $ath);
                continue;
            }else{ // else we split the value by ' ' and if the word/words exist in publishers table
                $pub = new Publisher;
                $nath = explode('and', $ath);
                $nath_c = count($nath);

                // if there 2 names (name1 and name2)
                if($nath_c > 1){
                    foreach($nath as $a){
                        // if a name looks like a publisher we skip it 
                        if(count($pub->getApproximateName($a))){
                            continue;
                        }
                        array_push($authors, $a);
                    }
                    continue;
                }

                $nath = explode(' ', $ath);

                foreach($nath as $a){
                    if(count($pub->getApproximateName($a))){
                        continue 2;
                    }
                }

                // the name is not a publisher name
                array_push($authors, $ath);
            }
        }

        return $authors;
    }

    /**
     * Sort the API search results
     * insert new articles, skip inserted one. add the authors and publisher 
     * 
     * @param Response
     * 
     * @return boolean
     */
    public function sortResponseData($res){
        // get response data as JSON
        $arts = $res->json();

        foreach($arts['articles'] as $a){
            // author/authors of the article
            $authors = array();

            // publisher
            if(isset($a['source']['id'])){
                // if publisher exists
                $pub = new Publisher($a['source']['id'], $a['source']['name']);
                // insert the non existing publisher
                if(!$pub->exists()){
                    $pub = $pub->add();
                }else{ // publisher exists and we return it
                    $pub = $pub->getPublisher($a['source']['id']);
                }
            }

            // authors
            if(isset($a['author'])){
                // sanitise author/authors 
                $sn_authors = $this->sanitizeAuthor($a['author']);
                // if author value is null or empty 
                // take the publisher name as an author
                if(!$sn_authors)
                    $sn_authors[] = $a['source']['name'];

                foreach($sn_authors as $ath){
                    $aut = new Author;
                    
                    // author doesn't exist
                    if(!$aut->exists($ath)){
                        $aut = $aut->add($ath);
                        // push the authors id into an array of int
                        array_push($authors, $aut->id);
                    }else{ // author exists
                        $aut = $aut->getAuthor(null, $ath);
                        // push the authors id into an array of int
                        array_push($authors, $aut->id);
                    }
                }
            }
        }
    }
}



