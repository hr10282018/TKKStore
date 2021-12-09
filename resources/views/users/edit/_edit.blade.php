@extends('layouts.app')
@section('title', '编辑资料')

@section('content')

<div class="row ">

  <!-- 左侧·路由 -->
  <div class="list-group ml-4" style="width: 272px;">
    <i class="fas fa-caret-right" style="color:aqua"></i>

    <a href="{{ route('user_edit', Auth::user()) }}" class="list-group-item list-group-item-action ">
      <div style="margin-left:93px;">
        <i class="fas fa-user mr-2"></i>
        个人信息
      </div>

    </a>
    <a href="{{ route('user_edit_avatar', Auth::user()) }}" class="list-group-item list-group-item-action ">
      <div style="margin-left:93px; " class="row">
        <i class="far fa-image mr-1 mt-2" style="font-size: 18px; "></i>
        <div class="ml-1 mt-1">修改头像</div>
      </div>
    </a>
    <a href="{{ route('user_edit_password', Auth::user()) }}" class="list-group-item list-group-item-action ">
      <div style="margin-left:93px;">
      <i class="fas fa-lock mr-2"></i>
        修改密码
      </div>
    </a>
    <a href="#" class="list-group-item list-group-item-action ">
      <div style="margin-left:93px;">
        <i class="fas fa-user mr-2"></i>
        显示设置
      </div>
    </a>
  </div>

  <!-- 右边信息 -->
  @yield('edit_info')

</div>


@stop
