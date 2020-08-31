<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Comments\CommentRequest;

use App\Comment;
use Auth;

class CommentsController extends Controller
{
    /**
     * construct
     */
    public function __construct(){
        $this->middleware("auth");
    }


    /**
     * comment on an article
     * 
     */
    public function comment(CommentRequest $request){
        $user = Auth::id();
        $article = $request->article;
        $body = $request->comment;

        $comment = (new Comment)->commentOnArticle($user, $article, $body);

        // return a reponse JSON
        if(isset($comment)){
            return response()->json(
                [
                    "success" => true,
                    "comment" => $comment,
                    "user" => $comment->user
                ],
                200, 
                ['Content-Type' => 'application/json;charset=utf8'], 
                JSON_UNESCAPED_UNICODE
            );
        }else{
            return response()->json(
                [
                    "success" => false,
                    "comment" => null
                ], 
                403, 
                ['Content-Type' => 'application/json;charset=utf8'], 
                JSON_UNESCAPED_UNICODE
            );
        }
    }
}
