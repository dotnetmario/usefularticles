<?php

namespace App\Http\Controllers;

use App\Http\Requests\Replies\ReplyRequest;

use App\Reply;
use Auth;

class RepliesController extends Controller
{
    /**
     * contruct
     * 
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * reply to a comment
     * 
     */
    public function reply(ReplyRequest $request){
        $comment = $request->comment;
        $reply = $request->reply;

        $reply = new Reply($comment, Auth::id(), $reply);
        $reply = $reply->replyToComment();

        // return a JSON reponse
        if(isset($reply)){
            return response()->json(
                [
                    "success" => true,
                    "reply" => $reply,
                    "user" => $reply->user
                ],
                200, 
                ['Content-Type' => 'application/json;charset=utf8'], 
                JSON_UNESCAPED_UNICODE
            );
        }else{
            return response()->json(
                [
                    "success" => false,
                    "reply" => null
                ], 
                403, 
                ['Content-Type' => 'application/json;charset=utf8'], 
                JSON_UNESCAPED_UNICODE
            );
        }
    }
}
