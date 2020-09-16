<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/test', array('as' => 'test', 'uses' => 'HomeController2@test'));
Route::get('/populate', array('as' => 'test', 'uses' => 'HomeController2@populate2'));
Auth::routes();


Route::get('/', array('as' => 'index', 'uses' => 'HomeController@index'));
Route::post('/search', array('as' => 'search', 'uses' => 'SearchController@search'));
// article param is a permalink 
Route::get('/article/{article}', array('as' => 'article', 'uses' => 'ArticlesController@article'));
Route::post('/comment', array('as' => 'comment', 'uses' => 'CommentsController@comment'));
Route::post('/reply', array('as' => 'reply', 'uses' => 'RepliesController@reply'));
