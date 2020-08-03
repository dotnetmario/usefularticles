<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;

use App\Search;

class SearchController extends Controller
{
    //

    /**
     * search
     */
    public function search(SearchRequest $request){
        // dd($request);
        $srch = new Search($request);
        $res = $srch->getSearchResults();

        dd($res);
    }
}
