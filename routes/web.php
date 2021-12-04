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


Route::get('/', 'PagesController@root');

Route::get('signup', 'UsersController@create')->name('signup'); // 注册

Route::post('/users', 'UsersController@store')->name('users.store');  // 处理注册


