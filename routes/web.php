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


Route::get('/', 'PagesController@root')->name('home');  // 主页

/* 注册路由 */
Route::get('/signup', 'UsersController@create')->name('signup'); // 注册页面

Route::post('/register', 'UsersController@register')->name('users.register');  // 处理注册表单信息
// ajax用户名和邮箱
Route::get('ajax_name/{name}', 'UsersController@name_ajax')->name('name_ajax');
Route::get('ajax_email/{email}', 'UsersController@email_ajax')->name('email_ajax');


/* 登录路由 */
Route::get('/login', 'SessionsController@login_show')->name('login_show'); // 登录页面
//Route::get('login', 'SessionsController@create')->name('login');    //
Route::post('login', 'SessionsController@login_check')->name('login_check'); // 处理登录信息
Route::delete('logout', 'SessionsController@login_out')->name('login_out');   // 退出登录

/* 用户个人中心 */


