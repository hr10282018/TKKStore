@extends('layouts.app')
@section('title', '个人主页')

@section('content')

<div class="row ">
  <div class="col-lg-2 col-md-1 hidden-sm hidden-xs user-info">
    <div class="card " style="width: 274px;">
      <ul class="list-group list-group-flush  ">
        <a href="{{ route('user_edit_avatar',Auth::user()) }}">
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
          <p class="card-text">两个月前</p>
        </div>
        <li class="list-group-item " style="width: 230px; margin:0 auto;"></li>

        <div class="card-body" style="height:60px">
          <a href="{{ route('user_edit',Auth::user()) }}" class="btn btn-default btn-outline-info" style="width:215px; height:35px">
            <i class="fas fa-user-edit"></i>
            编辑个人资料
          </a>
        </div>
        <li class="list-group-item " style="width: 230px; height:2px; margin:0 auto;"></li>
      </ul>
    </div>
  </div>

  <!-- 中间信息 -->
  @yield('user_info')


  <!-- 右侧栏链接 -->
  <div class="list-group ml-3" style="width: 200px;">

    <div class="card">
      <i class="fas fa-caret-left" style="color:aqua"></i>
      <li class="list-group-item "> <strong style="font-size: 16px; color:#a5a5a5">我的信息</strong></li>

      <a href="{{ route('user_show',$user->id) }}" class="list-group-item list-group-item-action active">
      <i class="fas fa-user mr-2"></i>
        基本资料
      </a>

      <a href="#" class="list-group-item list-group-item-action ">
        <i class="fas fa-heart mr-1"></i>
        我的预订
      </a>

      <a href="#" class="list-group-item list-group-item-action">
        <i class="fab fa-twitch" style="font-size:17px"></i>
        我的购买
      </a>
      <a href="#" class="list-group-item list-group-item-action">
        <i class="fab fa-twitch" style="font-size:17px"></i>
        我的留言
      </a>
    </div>

    <div class="card mt-3">
      <li class="list-group-item "> <strong style="font-size: 16px; color:#a5a5a5">我的店铺</strong></li>
      <a href="#" class="list-group-item list-group-item-action">
        <img src="/images/order3.png" alt=""  style="width: 18px; height:18px; margin-right:1px">
        我的订单
      </a>
      <!-- <a href="#" class="list-group-item list-group-item-action active-a">
        <i class="fas fa-paper-plane mr-1"></i>
        我的发布
      </a> -->
      <a href="{{ route('sale_goods',$user->id) }}" class="list-group-item list-group-item-action">
        <i class="fas fa-store"></i>
        我的商品
      </a>

      <a href="#" class="list-group-item list-group-item-action">
        我的xx
      </a>
    </div>

  </div>



</div>

@stop
