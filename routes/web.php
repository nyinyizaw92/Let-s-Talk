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

Auth::routes();

Route::resource('/user', 'UserController')->middleware('auth');
Route::resource('/post-like', 'UserLikePostController')->middleware('auth');

Route::get('/', 'LatestPostController@index');
// Route::get('/post/{id}', 'PostController@show');
Route::resource('/post', 'PostController')->middleware('auth')->except(['show', 'index']);
Route::get('/post/index', 'PostController@index')->name('index');
Route::get('/post/show/{id}', 'PostController@show')->name('show');

Route::resource('/category', 'CategoryController')->middleware('auth');
Route::resource('/comment', 'CommentController')->middleware('auth');
Route::resource('/reply-comment', 'ReplyCommentController')->middleware('auth');
// Route::get('/latest-post', 'LatestPostController@index')->name('latest-post');
