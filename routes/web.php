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
Auth::routes();


Route::get('/', array('as' => 'index', 'uses' => 'HomeController@index'));
Route::post('/', array('as' => 'search', 'uses' => 'SearchController@search'));
