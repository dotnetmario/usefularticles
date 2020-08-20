<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;

use App\Search;
use App\NewsAPI;

class SearchController extends Controller
{
    //

    /**
     * search
     */
    public function search(SearchRequest $request){
        // pass the request and get serch reesults from the API
        $srch = new Search($request);
        // raw data coming from the API
        $res = $srch->getSearchResults();

        // sort through data and save the new results
        $api = new NewsAPI;
        $sort = $api->sortResponseData($res);

        dd($res);
    }
}
