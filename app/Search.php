<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\NewsAPI;

class Search extends Model
{
    protected $_req;

    /**
     * constructor
     * 
     * @param Request req
     */
    public function __construct($req = null){
        $this->_req = $req;
    }


    /**
     * get search results from search params
     * 
     * 
     */
    public function getAPISearchResults($req = null){
        $api = new NewsAPI;
        $r = null;

        // test on the request param if present 
        // with priority to the function's param
        $r = $req ?? $this->_req;
        
        if(!isset($r))
            return null;

        $query = isset($r->squery) && $r->squery ? $r->squery : null;
        $artsPerPage = isset($r->artsPerPage) && $r->artsPerPage ? $r->artsPerPage : 20;
        $page = isset($r->page) && $r->page ? $r->page : 1;
        $inTitle = isset($r->inTitle) && $r->inTitle ? $r->inTitle : $query;
        $source = isset($r->source) && $r->source ? $r->source : null;
        $domain = isset($r->domain) && $r->domain ? $r->domain : null;
        $exDomain = isset($r->exDomain) && $r->exDomain ? $r->exDomain : null;
        $from = isset($r->from) && $r->from ? $r->from : null;
        $to = isset($r->to) && $r->to ? $r->to : null;
        // instead of a global default lang this should be coming from a localisation value
        $lang = isset($r->lang) && $r->lang ? $r->lang : config('capp.default-lang');
        $sortBy = isset($r->sortBy) && $r->sortBy ? $r->sortBy : null;
        
        $res = $api->getEverything(
                        $query,
                        $artsPerPage,
                        $page,
                        $inTitle,
                        $source,
                        $domain,
                        $exDomain,
                        $from,
                        $to,
                        $lang,
                        $sortBy
                    );

        return $res;
    }
}
