<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
  'prefix'        => config('admin.route.prefix'),
  'namespace'     => config('admin.route.namespace'),
  'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

  $router->get('/', 'HomeController@index')->name('admin.home');

  /* 用户 */
  $router->get('users', 'UsersController@index');     // 用户列表
  $router->get('users/{id}', 'UsersController@show');    // 详情
  $router->delete('delete_users/{id}', 'UsersController@delete');    // 删除

  /* 商品 */
  $router->get('goods', 'GoodsController@index');     // 列表
  $router->get('goods/{id}/edit', 'GoodsController@edit');   // 审核
  $router->post('check_goods/{id}', 'GoodsController@admin_check_goods')->name('admin_check_goods');       // 审核处理
  $router->get('goods/{id}', 'GoodsController@show');    // 详情
  $router->delete('delete_goods/{id}', 'GoodsController@delete');    // 删除

  /* 评论 */
  $router->get('comments', 'CommentsController@index');     // 列表
  $router->get('comments/{id}', 'CommentsController@show');    // 详情
  $router->delete('delete_comments/{id}', 'CommentsController@delete');    // 删除


  /* 预定 */
  $router->get('bookings', 'BookingsController@index');     // 列表
  $router->get('bookings/{id}', 'BookingsController@show');    // 详情
  //$router->delete('delete_bookings/{id}', 'BookingsController@delete');    // 删除

  
  /* 订单 */
  $router->get('orders', 'OrdersController@index');     // 列表
  $router->get('orders/{id}', 'OrdersController@show');    // 详情
  //$router->delete('delete_orders/{id}', 'OrdersController@delete');    // 删除

  /* 用户可见 */
  $router->get('user_visibles', 'UserVisiblesController@index');     // 列表
  $router->get('user_visibles/{id}', 'UserVisiblesController@show');    // 详情
  //$router->delete('delete_orders/{id}', 'OrdersController@delete');    // 删除

  /* 商品分类 */
  $router->get('categories', 'CategoriesController@index');     // 列表
  $router->get('categories/{id}', 'CategoriesController@show');    // 详情
  $router->get('categories/{id}/edit', 'CategoriesController@edit');   // 编辑
  $router->post('edit_categories/{id}', 'CategoriesController@admin_edit_categories');    // 处理编辑
  $router->get('category/create', 'CategoriesController@create');   // 新增
  $router->post('create_category', 'CategoriesController@admin_create_categories');   // 处理新增
  
  /* 商品标签 */
  $router->get('good_tags', 'GoodTagsController@index');     // 列表
  //$router->get('good_tags/{id}', 'GoodTagsController@show');    // 
  //$router->get('good_tags/{id}/edit', 'GoodTagsController@edit');   // 
  // $router->get('good_tags/create', 'GoodTagsController@create');   // 
  $router->resource('good_tags', 'GoodTagsController',['only'=>['show','create','edit']]);   // 详情、新增、编辑
  $router->post('create_good_tags', 'GoodTagsController@admin_create_good_tags');   // 处理新增
  $router->post('edit_good_tags/{id}', 'GoodTagsController@admin_edit_good_tags');    // 处理编辑
  $router->delete('delete_good_tags/{id}', 'GoodTagsController@delete');    // 删除

});
