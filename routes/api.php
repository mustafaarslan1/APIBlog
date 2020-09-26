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
        Route::post('/add', 'CategoryController@add');
        Route::put('/{categoryid}', 'CategoryController@update');
        Route::delete('/{categoryid}', 'CategoryController@delete');
    });
});

Route::namespace('App\Http\Controllers')->group(function (){
    Route::prefix('tags')->group(function (){
        Route::get('/', 'TagController@index');
        Route::get('/{tagid}', 'TagController@detail');
        Route::post('/add', 'TagController@add');
        Route::put('/{tagid}', 'TagController@update');
        Route::delete('/{tagid}', 'TagController@delete');
    });
});

Route::namespace('App\Http\Controllers')->group(function (){
    Route::prefix('articles')->group(function (){
        Route::get('/', 'ArticleController@index');
        Route::get('/{tagid}', 'ArticleController@detail');
        Route::post('/add', 'ArticleController@add');
        Route::put('/{tagid}', 'ArticleController@update');
        Route::delete('/{tagid}', 'ArticleController@delete');
        Route::post('/addTag', 'ArticleController@addTag');
        Route::delete('/deleteTag/{articletagid}', 'ArticleController@deleteTag');
        Route::post('/addCategory', 'ArticleController@addCategory');
        Route::delete('/deleteCategory/{articlecategoryid}', 'ArticleController@deleteCategory');
    });
});


