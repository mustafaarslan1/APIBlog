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
        Route::get('/{category-id}', 'CategoryController@detail');
        Route::post('/add', 'CategoryController@add');
        Route::put('/{category-id}', 'CategoryController@update');
        Route::delete('/{category-id}', 'CategoryController@delete');
        Route::post('/add-tag', 'CategoryController@addTag');
        Route::delete('/delete-tag/{category-tag-id}', 'CategoryController@deleteTag');
    });
});

Route::namespace('App\Http\Controllers')->group(function (){
    Route::prefix('tags')->group(function (){
        Route::get('/', 'TagController@index');
        Route::get('/{tag-id}', 'TagController@detail');
        Route::post('/add', 'TagController@add');
        Route::put('/{tag-id}', 'TagController@update');
        Route::delete('/{tag-id}', 'TagController@delete');
    });
});

Route::namespace('App\Http\Controllers')->group(function (){
    Route::prefix('articles')->group(function (){
        Route::get('/', 'ArticleController@index');
        Route::get('/{article-id}', 'ArticleController@detail');
        Route::post('/add', 'ArticleController@add');
        Route::put('/{article-id}', 'ArticleController@update');
        Route::delete('/{article-id}', 'ArticleController@delete');
        Route::post('/add-tag', 'ArticleController@addTag');
        Route::delete('/delete-tag/{article-tag-id}', 'ArticleController@deleteTag');
        Route::post('/add-category', 'ArticleController@addCategory');
        Route::delete('/delete-category/{article-category-id}', 'ArticleController@deleteCategory');
    });
});


