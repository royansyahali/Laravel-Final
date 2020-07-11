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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('pertanyaans', 'PertanyaanController');
Route::get('/komentars-pertanyaan/{id}', 'PertanyaanController@komentar')->name('komentars.pertanyaan.index');
Route::get('/jawabans', 'JawabanController@index')->name('jawabans.index');
Route::post('/jawabans/{id}', 'JawabanController@store')->name('jawabans.store');
Route::get('/jawabans/{id}', 'JawabanController@show')->name('jawabans.show');
Route::post('/komentars-jawaban/{id}', 'KomentarController@jawabanstore')->name('komentars.jawaban');
Route::post('/komentars-pertanyaan/{id}', 'KomentarController@pertanyaanstore')->name('komentars.pertanyaan');
Route::delete('/upvote-pertanyaan/{id}', 'PertanyaanController@upvote')->name('upvote.pertanyaan');
Route::delete('/downvote-pertanyaan/{id}', 'PertanyaanController@downvote')->name('downvote.pertanyaan');
Route::delete('/upvote-jawaban/{id}', 'JawabanController@upvote')->name('upvote.jawaban');
Route::delete('/downvote-jawaban/{id}', 'JawabanController@downvote')->name('downvote.jawaban');

Route::delete('/valid-jawaban/{id}', 'JawabanController@valid')->name('valid.jawaban');
