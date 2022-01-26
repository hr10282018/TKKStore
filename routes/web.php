<?php

use Illuminate\Support\Facades\Route;



/* 商品路由 */
Route::get('/goods', 'PagesController@root')->name('home');  // 主页-商品列表
Route::get('/category/{category_id}', 'PagesController@category_show')->name('category');  // 商品列表分类
Route::get('/goods_search', 'GoodsController@goods_search')->name('goods_search'); // 处理商品搜索
Route::get('/goods/{goods_id}/detail', 'GoodsController@goods_detail')->name('goods_detail');  // 商品详情页

/* 用户评论 */
Route::post('/goods/{goods_id}/detail', 'CommentsController@goods_detail_comment')->name('goods_detail_comment');
Route::delete('/goods/{goods_id}/detail', 'CommentsController@delete_comment')->name('delete_comment'); // 删除评论

/* 预订商品 */
Route::post('/goods/{goods_id}/detail', 'BookingsController@booking_goods')->name('booking_goods');


/* 注册路由 */
Route::get('/signup', 'UsersController@create')->name('signup'); // 注册页面

Route::post('/register', 'UsersController@register')->name('users.register');  // 处理注册表单信息
// ajax用户名和邮箱
Route::get('ajax_name/{name}', 'UsersController@name_ajax')->name('name_ajax');
Route::get('ajax_email/{email}', 'UsersController@email_ajax')->name('email_ajax');


/* 登录路由 */
Route::get('login', 'SessionsController@login')->name('login'); // 登录页面
//Route::get('login', 'SessionsController@create')->name('login');    //
Route::post('login', 'SessionsController@login_check')->name('login_check'); // 处理登录信息
Route::delete('logout', 'SessionsController@login_out')->name('login_out');   // 退出登录

/* 用户个人中心 */
Route::get('/users/{user}', 'UsersController@user_show')->name('user_show');  // 主页展示

Route::get('/users/{user}/sale_goods', 'UsersController@sale_goods')->name('sale_goods');  // 我的商品
Route::delete('/users/{user}/delete_goods', 'UsersController@delete_goods')->name('delete_goods');  // 删除商品

Route::get('/users/{user}/booking_notice', 'UsersController@booking_notice')->name('booking_notice');  // 预订通知
Route::put('/users/{user}/agree_booking/{booking_id}', 'UsersController@agree_booking')->name('agree_booking');  // 接受预订
Route::post('/users/{user}/refuse_booking/{booking_id}', 'UsersController@refuse_booking')->name('refuse_booking');  // 拒绝预订

Route::get('/users/{user}/user_booking', 'UsersController@user_booking')->name('user_booking');  // 我的预订


Route::get('/users/{user}/settings/edit', 'UsersController@edit')->name('user_edit');  // 修改信息
Route::put('/users/{user}/settings/check_edit', 'UsersController@edit_check')->name('user_edit_check');    // 修改基本信息表单

Route::get('/users/{user}/settings/edit_avatar', 'UsersController@edit_avatar')->name('user_edit_avatar');  // 修改头像
Route::put('/users/{user}/settings/check_avatar', 'UsersController@avatar_check')->name('user_edit_avatar_check');    // 修改头像表单

Route::get('/users/{user}/settings/edit_password', 'UsersController@edit_password')->name('user_edit_password');  // 修改密码
Route::post('/users/{user}/settings/check_password', 'UsersController@password_check')->name('user_edit_password_check');  // 修改密码表单


/* 邮箱认证 */
Route::get('/signup/email/verify', 'SessionsController@show_verify')->name('show_verify'); // 验证界面
Route::get('/signup/email/verify/{token}', 'SessionsController@signup_verify')->name('signup_verify'); // 登录验证
Route::post('/signup/email/verify/{token}', 'SessionsController@signup_verify2')->name('signup_verify'); // 再次验证

/*发布商品*/
Route::get('/create_goods', 'GoodsController@create_goods')->name('create_goods'); // 发布商品页面
Route::put('/create_goods', 'GoodsController@create_goods_check')->name('create_goods'); // 处理发布商品



