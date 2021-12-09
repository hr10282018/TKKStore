
<!-- 个人主页的默认路由-基本信息 -->
@extends('users.show')
@section('user_info')

 <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;">
    <div class="card " style="height: 51px;">
      <div class="card-body" style="line-height:22px">
          <h1 class="mb-0" style="font-size:20px;line-height:12px">{{ $user->name }}，<small>最后活跃于：1天前</small></h1>
      </div>
    </div>


    <div class="card mt-4">
      <div class="card-body">
        暂无数据 ~_~
      </div>
    </div>

  </div>
@stop
