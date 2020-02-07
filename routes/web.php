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

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => 'can:admin-panel'], function() {

    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('users', 'UsersController');
    Route::post('/users/{user}/switch', 'UsersController@switch')->name('users.switch');
});

Route::group([
    'prefix' => 'projects',
    'as' => 'projects.',
    'middleware' => 'auth'
], function() {

    Route::get('/','ProjectController@index')->name('index');
    Route::get('/create','ProjectController@create')->name('create');
    Route::post('/store','ProjectController@store')->name('store');
    Route::get('/{project}/edit','ProjectController@edit')->name('edit');
    Route::put('/{project}/update','ProjectController@update')->name('update');
    Route::get('/{project}/show','ProjectController@show')->name('show');
    Route::delete('/{project}/destroy','ProjectController@destroy')->name('destroy');
    Route::get('/{project}/report', 'ProjectController@report')->name('report');
});