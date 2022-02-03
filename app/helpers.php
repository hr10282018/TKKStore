<?php

// 针对不同路由返回class名，样式
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

// function category_nav_active($category_id)
// {
//   return active_class((if_route('category') && if_route_param('category_id', $category_id)));
// }


// 分类选中样式-逻辑
function category_active($category_id)    // 有分类的查询+最新发布-返回
{
  if((if_route('category') && if_route_param('category_id', $category_id))){
    return active_class(true);
  }elseif((if_route('goods_search')) && if_query ('category_id', $category_id) ){
    return active_class(true);
  }elseif((if_route('goods_detail')) && if_query ('from', $category_id)){
    return active_class(true);
  }

}


function search_no_category_active()    // 无分类的查询+最新发布-返回
{
  return active_class(((if_route('goods_search')) && if_query ('category_id','')) || (if_route('goods_detail')) && if_query ('from', 'all') );
}

// 编辑资料-左边链接样式
function user_info_active($type){
  if($type=='arrow'){
    if ((if_route('user_edit'))) {
      return '17';
    } elseif ((if_route('user_edit_avatar'))) {
      return '68';
    } elseif ((if_route('user_edit_password'))) {
      return '116';
    } elseif ((if_route('user_edit_visible'))) {
      return '162';
    }
  }else{
    if ((if_route('user_edit')) && $type==0 ) {
      return 'background-color: rgb(242,242,242);';
    }
    if ((if_route('user_edit_avatar')) && $type == 1) {
      return 'background-color: rgb(242,242,242);';
    }
    if ((if_route('user_edit_password')) && $type == 2) {
      return 'background-color: rgb(242,242,242);';
    }
    if ((if_route('user_edit_visible')) && $type == 3) {
      return 'background-color: rgb(242,242,242);';
    }
  }
}

// 个人中心-右边链接样式
function user_center_active($type){
  if ($type == 'arrow') {
    if ((if_route('user_show'))) {
      return '65';
    } elseif ((if_route('user_booking'))) {
      return '114';
    } elseif ((if_route('sale_goods'))) {
      return '326';
    } elseif ((if_route('booking_notice'))) {
      return '375';
    }
  }else{
    if ((if_route('user_show')) && $type==0 ) {
      return 'active';
    }
    if ((if_route('user_booking')) && $type == 1) {
      return 'active';
    }
    if ((if_route('sale_goods')) && $type == 4) {
      return 'active';
    }
    if ((if_route('booking_notice')) && $type == 5) {
      return 'active';
    }
  }

}



