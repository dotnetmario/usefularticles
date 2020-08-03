<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsAPI;
use App\Publisher;
use App\Author;
use App\Article;

class HomeController2 extends Controller
{
    public function test(Request $request){
        // 'politico', 'Politico', null
        // $pub = new Publisher(null, 'Rolling Stone');
        // $p = $pub->getPublisher();
        // dd($pub, $pub, $p, $p->remove($p->id));

        // $url = new Article(null, null, 'this j\'ust an@ ord/in@ary t*itle[]{}!?');
        // $res = $url->generatePermalink();
        // dd($res, $url->permalink);
        // // header('Location: '.$url);
        // // exit();
        // // dd($url);

        // $art = new Article;
        // $art = $art->where('id', 56);
        // $art = $art->get();
        // dd($art);

        // $arts = Article::get();

        // foreach($arts as $art){
        //     $a = (new Article)->find($art->id);
        //     $perma = $a->generatePermalink($art->title);
        //     // dd($art->title, $perma);
        //     $test = $a->exists($perma, "permalink");
        //     // dd($test, $perma);
        //     if(!$test){
        //         $a->permalink = $perma;
        //         $a->save();
        //     }
            
        // }
        

        dd("done");
    }


    public function populate(Request $request){
        $api = new NewsAPI;

        $res = $api->getTopHeadlines('', 20, 1, 'us',);

        // dd($api, $res, $res->json());
        $arts = $res->json();
        
        foreach($arts['articles'] as $a){
            
            // author/authors of the article
            $authors = array();

            // the id of the publisher is provided by the API
            if(isset($a['source']['id'])){
                // test if publisher exists
                $pub = new Publisher($a['source']['id'], $a['source']['name']);
                // insert a the non existing publisher
                if(!$pub->exists()){
                    $pub = $pub->add();
                }else{ // publisher exists and we return it
                    $pub = $pub->getPublisher($a['source']['id']);
                }
            }else{ // the api id was not provided by the API need look it up by name
                if(!$pub->exists(null, $a['source']['name'])){
                    // $a['source']['id'] is null
                    $pub = $pub->add($a['source']['name'], $a['source']['id']);
                }else{
                    $pub = $pub->getPublisher(null, $a['source']['name']);
                }
            }

            // sanitize and insert new authors
            if(isset($a['author'])){
                $sn_authors = $api->sanitizeAuthor($a['author']);
                // if author value is null or empty
                if(!$sn_authors)
                    $sn_authors[] = $a['source']['name'];

                foreach($sn_authors as $ath){
                    $aut = new Author;
            
                    if(!$aut->exists($ath)){
                        $aut = $aut->add($ath);
                        // push the authors id as an array of int
                        array_push($authors, $aut->id);
                    }else{
                        $aut = $aut->getAuthor(null, $ath);
                        array_push($authors, $aut->id);
                    }
                }
            }

            $art = new Article;

            // dd($pub, $aut);
            if(isset($a['url']) && !$art->exists($a['url']))
                $art->add($pub->id, $authors, $a['title'], $a['description'], $a['url'], $a['urlToImage'], date('Y-m-d H:i:s', strtotime($a['publishedAt'])) );

            // dd($pub, $aut, $art);
        }
    }
}
