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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/candidates/create', 'CandidateController@create')->name('create');
Route::post('/candidates', 'CandidateController@store')->name('candidate.store');

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('/candidates', 'CandidateController@index')->name('candidates.index');
    Route::get('/candidates/{uuid}', 'CandidateController@show');
    Route::post('/comments', 'CommentController@store')->name('comment.store');
    
});
