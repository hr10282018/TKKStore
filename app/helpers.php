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


