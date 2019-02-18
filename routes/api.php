<?php

use Illuminate\Http\Request;

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

Route::resource('comment', 'API\CommentController');

Route::get('film/{slug}', 'API\FilmController@show');// For the purpose of show method that uses slug
Route::resource('film', 'API\FilmController')->except([
    'show'
]);


Route::post('/login', 'API\AuthController@login');
Route::post('/logout', 'API\AuthController@logout');
Route::post('/register', 'API\AuthController@register'); 

Route::get('slugify/{name}', 'API\FilmHelpers@slugify');
Route::get('getComment/{id}', 'API\CommentController@getComment');
