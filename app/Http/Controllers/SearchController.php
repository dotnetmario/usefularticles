<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Search\SearchRequest;

use App\Search;
use App\NewsAPI;
use App\Article;

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
        $res = $srch->getAPISearchResults();

        // sort through data and save the new results
        $api = new NewsAPI;
        $sort = $api->sortResponseData($res);

        // return search results
        $articles = new Article;
        $articles = $articles->getArticlesBySearchQuery();

        return view('home', compact('articles'));
    }
}
