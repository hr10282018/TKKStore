<?php

use Illuminate\Support\Facades\Route;


Route::redirect('/', 'goods')->name('root');  // 首页跳转

/* 商品展示 */
Route::get('goods', 'PagesController@root')->name('home');  // 主页-商品列表
Route::get('/category/{category_id}', 'PagesController@category_show')->name('category');  // 商品列表分类
Route::get('/goods_search', 'GoodsController@goods_search')->name('goods_search'); // 处理商品搜索
Route::get('/goods/{goods_id}/detail', 'GoodsController@goods_detail')->name('goods_detail');  // 商品详情页
Route::get('/goods/goods_hot', 'GoodsController@goods_hot')->name('goods_hot');  // 热门商品


/*发布商品*/
Route::get('/create_goods', 'GoodsController@create_goods')->name('create_goods'); // 发布商品页面
Route::put('/create_goods', 'GoodsController@create_goods_check')->name('create_goods_check'); // 处理发布商品
Route::get('/edit_goods/{goods_id}', 'GoodsController@edit_goods')->name('edit_goods'); // 编辑商品页面


/* 评论 */
Route::post('/goods/{goods_id}/detail/comments', 'CommentsController@goods_detail_comment')->name('goods_comment');  // 参与评论
Route::delete('/goods/{goods_id}/{comments_id}/delete', 'CommentsController@delete_comment')->name('delete_comment'); // 删除评论
Route::get('/users/{user}/user_comment/search', 'CommentsController@search_comment')->name('search_comment'); // 搜索


/* 预订商品 */
Route::post('/goods/{goods}/{user_id}', 'BookingsController@ajax_booking_goods')->name('ajax_booking_goods');
Route::get('/goods/booking_count/{goods}', 'BookingsController@ajax_booking_count')->name('ajax_booking_count');    // 预定次数
Route::delete('/goods/cancel_booking/{goods}', 'BookingsController@ajax_cancel_booking')->name('ajax_cancel_booking'); // 取消预定

Route::get('/goods/ajax_operate_premise', 'BookingsController@ajax_operate_premise')->name('ajax_operate_premise');    // 预定前提



/* 注册 */
Route::get('/signup', 'UsersController@create')->name('signup'); // 注册页面

Route::post('/register', 'UsersController@register')->name('users.register');  // 处理注册表单信息

Route::get('ajax_name/{name}', 'UsersController@name_ajax')->name('name_ajax'); // ajax验证用户名
Route::get('ajax_email/{email}', 'UsersController@email_ajax')->name('email_ajax'); // ajax验证邮箱


/* 登录 */
Route::get('login', 'SessionsController@login')->name('login'); // 登录页面
//Route::get('login', 'SessionsController@create')->name('login');    //
Route::post('login', 'SessionsController@login_check')->name('login_check'); // 处理登录信息
Route::post('logout', 'SessionsController@login_out')->name('login_out');   // 退出登录

/* 重设密码 */
Route::get('password/reset', 'SessionsController@password_send_email')->name('password_send_email'); // 重设密码
Route::post('password/reset', 'SessionsController@verify_password_send_email')->name('verify_password_send_email'); // 处理重设密码 邮件
Route::get('password/reset/{token}', 'SessionsController@reset_password')->name('reset_password');   // 密码修改
Route::post('password/reset/verify', 'SessionsController@verify_reset_password')->name('verify_reset_password');   // 处理面修改


/* 用户个人中心 */
Route::get('/users/{user}', 'UsersController@user_show')->name('user_show');  // 主页展示

Route::get('/users/{user}/user_booking', 'UsersController@user_booking')->name('user_booking');  // 我的预订
//Route::get('/users/{user}/user_booking/search', 'UsersController@search_booking')->name('search_booking'); // 搜索


Route::get('/users/{user}/user_comment', 'UsersController@user_comment')->name('user_comment');  // 我的评论

Route::get('/users/{user}/buy_goods', 'UsersController@buy_goods')->name('buy_goods');  // 订购商品(买家)
//Route::get('/users/{user}/buy_goods/search', 'UsersController@search_buy_goods')->name('search_buy_goods');  // 搜索-订购商品(买家)


Route::get('/users/{user}/buyer_order', 'UsersController@buyer_order')->name('buyer_order');  // 我的订单(买家)
Route::get('/users/{user}/buyer_order/search', 'UsersController@search_buyer_order')->name('search_buyer_order');  // 搜索-我的订单(买家)
Route::post('/buyer_refuse_order/{order}', 'OrdersController@buyer_refuse_order')->name('buyer_refuse_order');  // 拒绝订单(买家)
Route::post('/buyer_confirm_order/{order}', 'OrdersController@buyer_confirm_order')->name('buyer_confirm_order');  // 同意订单(买家)
Route::post('/buyer_cancel_order/{order}', 'OrdersController@buyer_cancel_order')->name('buyer_cancel_order');  // 取消订单(买家)


Route::get('/users/{user}/sale_goods/{state?}', 'UsersController@sale_goods')->name('sale_goods');  // 发布商品
Route::delete('ajax_del_gods/{goods}', 'UsersController@del_goods_ajax')->name('del_goods_ajax'); // ajax删除 发布商品
Route::get('/users/{user}/sale_goods/{state}/search', 'UsersController@search_sale_goods')->name('search_sale_goods');  // 搜索-发布商品


Route::get('/users/{user}/booking_notice', 'UsersController@booking_notice')->name('booking_notice');  // 预订通知
Route::post('/agree_booking/{booking_id}', 'BookingsController@agree_booking')->name('agree_booking');  // 接受预订
Route::post('/refuse_booking/{booking_id}', 'BookingsController@refuse_booking')->name('refuse_booking');  // 拒绝预订

Route::get('/users/{user}/seller_order', 'UsersController@seller_order')->name('seller_order');  // 出售订单(卖家)
Route::get('/users/{user}/seller_order/search', 'UsersController@search_seller_order')->name('search_seller_order');  // 出售订单(卖家)
Route::post('/seller_send_order/{order}', 'OrdersController@seller_send_order')->name('seller_send_order');  // 发送确认订单(卖家)
Route::post('/seller_cancel_order/{order}', 'OrdersController@seller_cancel_order')->name('seller_cancel_order');  // 取消订单(卖家)

Route::get('/users/{user}/settings/edit', 'UsersController@edit')->name('user_edit');  // 修改个人信息
Route::post('/users/{user}/settings/check_edit', 'UsersController@edit_check')->name('user_edit_check');    // 修改基本信息表单

Route::get('/users/{user}/settings/edit_avatar', 'UsersController@edit_avatar')->name('user_edit_avatar');  // 修改头像
Route::put('/users/{user}/settings/check_avatar', 'UsersController@avatar_check')->name('user_edit_avatar_check');    // 修改头像表单

Route::get('/users/{user}/settings/edit_password', 'UsersController@edit_password')->name('user_edit_password');  // 修改密码
Route::post('/users/{user}/settings/check_password', 'UsersController@password_check')->name('user_edit_password_check');  // 修改密码表单

Route::get('/users/{user}/settings/edit_visible', 'UsersController@edit_visible')->name('user_edit_visible');  // 显示设置
Route::get('ajax_visible', 'UsersController@ajax_visible')->name('ajax_visible'); // ajax获取显示设置
Route::post('/ajax_visible_data/{user_visible}', 'UsersController@ajax_visible_data')->name('ajax_visible_data'); // ajax修改显示设置


/* 邮箱认证 */
Route::get('/signup/email/verify/{user}', 'SessionsController@show_verify')->name('show_verify'); // 验证界面
Route::post('/signup/email/verify/{user}', 'SessionsController@second_send_email')->name('second_send_email'); // 再次发送邮件
Route::get('/signup/email/activate/{token}', 'SessionsController@signup_verify')->name('signup_verify'); // 邮箱激活


// 消息通知
Route::get('/notifications', 'NotificationsController@notifications')->name('notifications');  // 


