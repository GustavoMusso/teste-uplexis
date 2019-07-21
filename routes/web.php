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
    return redirect('/login');
});

Auth::routes();

Route::group(['prefix' => 'home', 'middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/create', 'HomeController@create')->name('home.create');
    Route::post('/store', 'HomeController@store')->name('home.store');
    Route::delete('delete/{id}', 'HomeController@delete')->name('home.delete');
});
