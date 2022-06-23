<?php

// 不同路由返回class名，样式
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

// 最新发布-选择时间
function new_goods_times($time){
  if(if_route('goods_search') && if_query ('time', $time)){
    return 'checked';
  }

}

function search_no_category_active()    // 无分类的查询+最新发布-返回
{
  return active_class(((if_route('goods_search')) && if_query ('category_id','')) || (if_route('goods_detail')) && if_query ('from', 'all') );
}

// 编辑资料-左边链接样式
function user_info_active($type){
  if($type === 'arrow'){
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
  if ($type === 'arrow') {
    if ((if_route('user_show'))) {
      return '65';            // 偏移px值
    } 
    elseif ((if_route('user_booking'))) {
      return '114';
    }
    elseif((if_route('user_comment')) || (if_route('search_comment'))){
      return '162';
    }
  
    elseif ((if_route('buy_goods'))) {
      return '207';
    } 
    elseif ((if_route('buyer_order')) ||  (if_route('search_buyer_order')) ) {
      return '257';
    } 
    elseif ((if_route('sale_goods')) ||  (if_route('search_sale_goods')) ) {
      return '374';
    } 
    elseif ((if_route('booking_notice'))) {
      return '422';
    }
    elseif ((if_route('seller_order')) ||  (if_route('search_seller_order')) ) {
      return '468';
    }

  }else{
    if ((if_route('user_show')) && $type==0 ) {
      return 'active';
    }
    if ((if_route('user_booking')) && $type == 1) {
      return 'active';
    }

    if (((if_route('user_comment')) || (if_route('search_comment'))) && $type == 2) {
      return 'active';
    }

    if ((if_route('buy_goods')) && $type == 3) {
      return 'active';
    }

    if (((if_route('buyer_order')) || (if_route('search_buyer_order'))) && $type == 4) {
      return 'active';
    }

    if (((if_route('sale_goods')) || (if_route('search_sale_goods'))) && $type == 5) {
      return 'active';
    }
    if ((if_route('booking_notice')) && $type == 6) {
      return 'active';
    }
    if (((if_route('seller_order')) || (if_route('search_seller_order'))) && $type == 7) {
      return 'active';
    }
    
  }

}


// 发布商品-状态选中样式
function my_goods_active($state){
  // 
  if($state == 0){
    if((if_route('sale_goods')|| if_route('search_sale_goods')) && (if_route_param('state', $state) || if_route_param('state', ''))){
      return true;
    }
  }

  if(((if_route('sale_goods')|| if_route('search_sale_goods'))&& if_route_param('state', $state))){
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


// 个人中心-出售订单、我的订单
function seller_orders_active($type){
  if($type == 'pending'){
    if(if_query('type','pending')){
      return true;
    }
    return false;
  }

  if($type == 'processed'){
    if(if_query('type','processed')){
      return true;
    }
    return false;
  }
}


/*  判断订单是否有效*/
// 目前所有情况中， 生效订单有：1-2、1-4，未生效订单有：2-3、1-3、2-1 ，取消订单有：0-1、0-3、1-0，(卖家状态 - 买家状态)

// 1.出售订单->待处理，卖家状态是 2，考虑 2-3、2-1
function seller_order_pending($seller_state,$buyer_state){
  
  if($seller_state == 2 && $buyer_state==1){
    return [false,'请根据买家拒绝原因修改订单信息！','买家核对订单拒绝',true]; //返回数据： 0-是否生效订单 1-未生效订单信息  2-[注]信息  4-是否需要编辑按钮
  }
  if($seller_state == 2 && $buyer_state==3){
    return [false,'请发送订单确认！','卖家未发送订单确认',true];
  }
 
}

// 2.出售订单->已处理，卖家状态在：0、1 之间，考虑 1-2、1-4、1-3
function seller_order_processed($seller_state,$buyer_state){
  
  if($seller_state == 1 && $buyer_state==2){
    return [true,'','双方已确认订单信息！',false];
  }
  if($seller_state == 1 && $buyer_state==4){
    return [true,'','买家超时自动同意订单！',false];
  }
  if($seller_state == 1 && $buyer_state==3){
    return [false,'等待买家核对订单！','买家未核对订单！',false];
  }
}
// 3.我的订单->待处理，买家状态是 3，考虑 1-3  2-3
function buyer_order_pending($seller_state,$buyer_state){

  if($seller_state == 2 && $buyer_state == 3){      
    return [false,'等待卖家发送订单确认！','卖家未发送订单确认！',true];      // 可以取消订单
  }

  if($seller_state == 1 && $buyer_state == 3){      
    return [false,'','买家未核对订单！',true];
  }
  

}

// 4.我的订单->已处理，买家状态在：0、1、2、4 之间，考虑：1-2、1-4、2-1 
function buyer_order_processed($seller_state,$buyer_state){

 
  if($seller_state == 1 && $buyer_state==4){      
    return [true,'','买家超时自动同意订单！',false];
  }
  if($seller_state == 1 && $buyer_state==2){      
    return [true,'','双方已确认订单信息！',false];
  }

  if($seller_state == 2 && $buyer_state==1){      
    return [false,'等待卖家修改订单信息！','卖家未修改订单信息！',false];
  }

}
