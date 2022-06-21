@extends('layouts.app')
@section('title', '个人主页')

@section('content')

<div class="row ">
  <div class="col-lg-2 col-md-1 hidden-sm hidden-xs user-info">
    <div class="card " style="width: 274px;">
      <ul class="list-group list-group-flush  ">
        <a href="{{ route('user_edit_avatar',$user->id) }}">
          <img src="{{ $user->avatar }}" class="card-img-top mt-4 ml-1 " style="width: 264px; height:262px; margin:0 auto; " alt="{{ $user->name }}">
        </a>
        <div class="mt-4" style="height:1px; width: 230px; background-color:rgb(223,223,223) ;margin:0 auto;"></div>
        <!-- <li class="list-group-item" style="height:1px; width: 230px; margin:0 auto;">
        xx
      </li> -->

        <div class="card-body">
          <h5 class="card-title"><strong>个性签名</strong></h5>
          <p class="card-text">{{ $user->signature }}</p>
        </div>
        <li class="list-group-item " style="width: 230px; margin:0 auto; "></li>

        <div class="card-body" style="height:76px">
          <h5 class="card-title"><strong>注册于</strong></h5>
          <p class="card-text" title="{{ $user->created_at }}">{{ $user->created_at->diffForHumans() }}</p>
        </div>
        <li class="list-group-item " style="width: 230px; margin:0 auto;"></li>

        <div class="card-body" style="height:60px">
          @if(Auth::user()->can('update_user_info', $user))
          <a href="{{ route('user_edit',Auth::user()) }}" class="btn edit_info" style="border:#3490dc 1px solid; width:215px; height:35px">
            <i class="fas fa-user-edit"></i>
            编辑个人资料
          </a>
          @endif
        </div>
        <li class="list-group-item " style="width: 230px; height:2px; margin:0 auto;"></li>
      </ul>
    </div>
  </div>

  <!-- 中间信息 -->
  @yield('user_info')


  <!-- 右侧栏链接 -->
  <i class="fas fa-caret-left " style="font-size:18px;color: #3490dc;left:17.5px; top: {{ user_center_active('arrow') }}px; position:relative;  z-index:5"></i>
  <div class="list-group ml-3" style="width: 200px;">

    <div class="card">
      <!-- <i class="fas fa-caret-left" style="color:aqua"></i> -->

      <li class="list-group-item ">
        <strong style="font-size: 16px; color:#a5a5a5">
          @if (Auth::user()->can('update_user_info', $user))
          我的信息
          @else
          Ta 的信息
          @endif
        </strong>
      </li>

      <a href="{{ route('user_show',$user->id) }}" style=" z-index:1" class="list-group-item list-group-item-action {{ user_center_active(0) }}">
        <i class="fas fa-user mr-2"></i>
          个人信息
      </a>

      <a href="{{ route('user_booking' , $user->id) }}?reply=no" style=" z-index:1;" class="list-group-item list-group-item-action {{ user_center_active(1) }}">
        <i class="fas fa-heart mr-1"></i>
        @if (Auth::user()->can('update_user_info', $user))
          我的预订
        @else
          Ta 的预订
        @endif
        
      </a>
      <a href="{{ route('user_comment' , $user->id)  }}"  style=" z-index:1;" class="list-group-item list-group-item-action {{ user_center_active(2) }}">
        <i class="fab fa-twitch mr-1" style="font-size:16px"></i>
        @if (Auth::user()->can('update_user_info', $user))
          我的评论
        @else
          Ta 的评论
        @endif
        
      </a>

      <a href="{{ route('buy_goods',$user->id) }}?type=booking" style=" z-index:1;"  class="list-group-item list-group-item-action  {{ user_center_active(3) }}">
        <i class="fas fa-shopping-cart " style="font-size: 15px;position:relative;left:-3px"></i>
        <span>订购商品</span>
      </a>

      <a href="{{ route('buyer_order',$user->id) }}?type=pending" style=" z-index:1;" class="list-group-item list-group-item-action {{ user_center_active(4) }}">
        <i class="fas fa-clipboard-list mr-1" style="font-size: 16px;"></i>
        <span>
        @if (Auth::user()->can('update_user_info', $user))
          我的订单
        @else
          Ta 的订单
        @endif
          
        </span>
      </a>

    </div>

    <div class="card mt-3">
      <li class="list-group-item "> 
        <strong style="font-size: 16px; color:#a5a5a5">
        @if (Auth::user()->can('update_user_info', $user))
          我的店铺
        @else
          Ta 的店铺
        @endif
        </strong>
        
      </li>

      <a href="{{ route('sale_goods',$user->id) }}" style=" z-index:1;" class="list-group-item list-group-item-action {{ user_center_active(5) }}">
        <i class="fas fa-store"></i>
        <span>发布商品</span>
      </a>

      <a href="{{ route('booking_notice',$user->id) }}?reply=no" style=" z-index:1;" class="list-group-item list-group-item-action {{ user_center_active(6) }}">
        <i class="far fa-envelope" style="font-size:17px"></i>
        <span class="ml-1">预订通知</span>
      </a>

      <a href="{{ route('seller_order',$user->id) }}?type=pending"  style=" z-index:1;" class="list-group-item list-group-item-action {{ user_center_active(7) }}">
        <img src="@if(user_center_active(7)=='active') /images/iconfont/order.png @else /images/iconfont/order_black.png @endif" alt="" style="width: 18px; height:18px; position:relative; top:-3px;left:0px">
        <span>出售订单</span>
      </a>

    </div>

  </div>

</div>

@stop
