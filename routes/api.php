<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'App\Http\Controllers\API\LoginController@login');
    Route::post('signup', 'App\Http\Controllers\API\LoginController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'App\Http\Controllers\API\LoginController@logout');
        Route::get('user', 'App\Http\Controllers\API\LoginController@user');
    });
});

Route::namespace('App\Http\Controllers')->group(function (){
    Route::prefix('categories')->group(function (){
        Route::get('/', 'CategoryController@index');
        Route::get('/{categoryid}', 'CategoryController@detail');
        Route::post('/add', 'CategoryController@add')->middleware(['auth:api','checkAuthor']);
        Route::put('/{categoryid}', 'CategoryController@update')->middleware(['auth:api','checkAuthor']);
        Route::delete('/{categoryid}', 'CategoryController@delete')->middleware(['auth:api','checkAuthor']);
        Route::post('/add-tag', 'CategoryController@addTag')->middleware(['auth:api','checkAuthor']);
        Route::delete('/delete-tag/{categorytagid}', 'CategoryController@deleteTag')->middleware(['auth:api','checkAuthor']);
    });
});

Route::namespace('App\Http\Controllers')->group(function (){
    Route::prefix('tags')->group(function (){
        Route::get('/', 'TagController@index');
        Route::get('/{tagid}', 'TagController@detail');
        Route::post('/add', 'TagController@add')->middleware(['auth:api','checkAuthor']);
        Route::put('/{tagid}', 'TagController@update')->middleware(['auth:api','checkAuthor']);
        Route::delete('/{tagid}', 'TagController@delete')->middleware(['auth:api','checkAuthor']);
    });
});

Route::namespace('App\Http\Controllers')->group(function (){
    Route::prefix('articles')->group(function (){
        Route::get('/', 'ArticleController@index');
        Route::get('/{articleid}', 'ArticleController@detail');
        Route::post('/add', 'ArticleController@add')->middleware(['auth:api','checkAuthor']);
        Route::put('/{articleid}', 'ArticleController@update')->middleware(['auth:api','checkAuthor']);
        Route::delete('/{articleid}', 'ArticleController@delete')->middleware(['auth:api','checkAuthor']);
        Route::post('/add-tag', 'ArticleController@addTag')->middleware(['auth:api','checkAuthor']);
        Route::delete('/delete-tag/{articletagid}', 'ArticleController@deleteTag')->middleware(['auth:api','checkAuthor']);
        Route::post('/add-category', 'ArticleController@addCategory')->middleware(['auth:api','checkAuthor']);
        Route::delete('/delete-category/{articlecategoryid}', 'ArticleController@deleteCategory')->middleware(['auth:api','checkAuthor']);
    });
});

Route::namespace('App\Http\Controllers')->group(function (){
    Route::prefix('newsletter')->group(function (){
        Route::get('/', 'NewsletterController@index')->middleware(['auth:api','checkAdmin']);
        Route::post('/add', 'NewsletterController@add');
        Route::put('/update/{newsletterid}', 'NewsletterController@disable');
    });
});


