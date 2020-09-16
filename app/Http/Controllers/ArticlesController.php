<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Articles\ArticleRequest;

use App\Article;

class ArticlesController extends Controller
{
    /**
     * shows a single article
     */
    public function article(ArticleRequest $request){
        $article = new Article;
        $permalink = $request->article;

        $article = $article->getArticle($permalink);

        $comments = $article->comments()->orderBy('created_at', 'DESC')->get();
        
        return view('article', compact('article', 'comments'));
    }
}
