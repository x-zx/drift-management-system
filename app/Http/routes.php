<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web','OpenAuth']], function () {
    //Route::controller('/','HomeController');
    Route::get('/','HomeController@getIndex');
    Route::controller('/home','HomeController');
    Route::controller('/item','ItemController');
    Route::controller('/article','ArticleController');
    Route::controller('/user','UserController');
    
    Route::controller('/transfer','TransferController');

    Route::controller('/admin','AdminController');
});


//Route::resource('articles','ArticlesController');
//Route::resource('users','UsersController');
//Route::resource('items','ItemsController');
//Route::resource('articles','ArticlesController');
//Route::resource('recommends','RecommendsController');


