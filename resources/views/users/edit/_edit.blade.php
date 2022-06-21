@extends('layouts.app')
@section('title', '编辑资料')

@section('content')

<div class="row ">
  <!-- 左侧·路由 -->
  <i class="fas fa-caret-right" style="font-size:18px;color: rgb(222,222,222);left:302px; top:{{ user_info_active('arrow') }}px; position:relative;  z-index:5"></i>

  <div class="list-group ml-4 " style="width: 272px; ">
    <a href="{{ route('user_edit', Auth::user()) }}" style="{{ user_info_active(0) }} z-index:1" class="list-group-item list-group-item-action">
      <div style="margin-left:93px;">
        <i class="fas fa-user mr-2"></i>
        基本信息
      </div>
    </a>

    <a href="{{ route('user_edit_avatar', Auth::user()) }}" style="{{ user_info_active(1) }} z-index:1" class="edit_avatar list-group-item list-group-item-action ">
      <div style="margin-left:91px; " class="row">
        <i class="far fa-image mr-1 mt-2" style="font-size: 18px; "></i>
        <div class="ml-1 mt-1">修改头像</div>
      </div>
    </a>
    <a href="{{ route('user_edit_password', Auth::user()) }}" style="{{ user_info_active(2) }} z-index:1" class="list-group-item list-group-item-action ">
      <div style="margin-left:93px;">
        <i class="fas fa-lock mr-2"></i>
        修改密码
      </div>
    </a>
    <a href="{{ route('user_edit_visible' , Auth::user()) }}" class="list-group-item list-group-item-action " style="{{ user_info_active(3) }} z-index:1">
      <div style="margin-left:93px;">
        <i class="fas fa-eye mr-2"></i>
        显示设置
      </div>
    </a>
  </div>

  <!-- 右边信息 -->
  @yield('edit_info')

</div>

@stop

@section('scriptsAfterJs')
<script>
  $(document).ready(function() {

  })
</script>


@stop
