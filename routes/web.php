<?php

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

// 404 Not Found はルーティング設定に問題あり

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::view('/{any}', 'spa')->where('any', '.*');

Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionsController')->except('show');
// Route::post('/questions/{question}/answers', 'AnswersController@store')->name('answers.store');
Route::resource('questions.answers', 'AnswersController')->except(['create', 'show']);  // 回答作成
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');    // 質問閲覧
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');  // チェック済み

Route::post('/questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');    // スター付与
Route::delete('/questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');  // スター外す

Route::post('/questions/{question}/vote', 'VoteQuestionController');  // 質問投票
Route::post('/answers/{answer}/vote', 'VoteAnswerController');  // 回答投票