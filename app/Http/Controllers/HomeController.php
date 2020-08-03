<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // get the latest articles
        $articles = new Article;

        $articles = $articles->getArticles('recent', null, null, 10);

        // dd($articles);


        return view('home', compact('articles'));
    }
}
