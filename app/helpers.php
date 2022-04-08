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
      return '65';            // 偏移px值
    } 
    elseif ((if_route('user_booking'))) {
      return '114';
    }
    elseif((if_route('user_comment'))){
      return '162';
    }
  
    elseif ((if_route('buy_goods'))) {
      return '207';
    } 
    elseif ((if_route('buyer_order'))) {
      return '257';
    } 
    elseif ((if_route('sale_goods'))) {
      return '374';
    } 
    elseif ((if_route('booking_notice'))) {
      return '422';
    }
    elseif ((if_route('seller_order'))) {
      return '468';
    }

  }else{
    if ((if_route('user_show')) && $type==0 ) {
      return 'active';
    }
    if ((if_route('user_booking')) && $type == 1) {
      return 'active';
    }

    if ((if_route('user_comment')) && $type == 2) {
      return 'active';
    }

    if ((if_route('buy_goods')) && $type == 3) {
      return 'active';
    }

    if ((if_route('buyer_order')) && $type == 4) {
      return 'active';
    }

    if ((if_route('sale_goods')) && $type == 5) {
      return 'active';
    }
    if ((if_route('booking_notice')) && $type == 6) {
      return 'active';
    }
    if ((if_route('seller_order')) && $type == 7) {
      return 'active';
    }
    
  }

}


// 我的商品-状态选中样式
function my_goods_active($state){
  // 
  if($state == 0){
    if(if_route('sale_goods') && (if_route_param('state', $state) || if_route_param('state', ''))){
      return true;
    }
  }

  if((if_route('sale_goods') && if_route_param('state', $state))){
    return true;
  }else{
    return false;
  }
}

// 商品详情-评论tab
function comment_tab(){
  if(if_query ('tab', 'comments')){
    return true;
  }else{
    return false;
  }
}

// 个人中心-我的预定
function reply_acyive($type){
  if($type == 'no'){
    if(if_query('reply','no')){
      return true;
    }
    return false;
  }
  
  if($type == 'yes'){
    if(if_query('reply','yes')){
      return true;
    }
    return false;
  }
}


// 个人中心-订购商品
function booking_buy_active($type){
  if($type == 'booking'){
    if(if_query('type','booking')){
      return true;
    }
    return false;
  }

  if($type == 'buy'){
    if(if_query('type','buy')){
      return true;
    }
    return false;
  }
}
