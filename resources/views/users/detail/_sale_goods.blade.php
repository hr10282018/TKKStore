<!-- 我的商品展示 -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;">

  <!-- <div class="card " style="height: 51px;">
      <div class="card-body" style="line-height:22px">
          <h1 class="mb-0" style="font-size:20px;line-height:12px">{{ $user->name }}，<small>最后活跃于：1天前</small></h1>
      </div>
    </div> -->

  <div class="card mb-5">
    <div class="card-body">
      <div class="row mt-2 ">
        <i class="fas fa-store mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
        <input id="user_id" type="text"  value="{{$user->id}}" hidden>
        <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
          {{$user->name}}
          <span style="letter-spacing:2px">发布的商品</span>
          （{{ count($user->goods) }}）
        </h1>
      </div>
    </div>

    <hr style="width: 650px;margin:0 auto;">

    <div class="card-body">
      {{-- 商品状态导航 --}}
      <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link @if(my_goods_active(0)) active @endif" id="unput-tab" data-toggle="tab" href="#unput" role="tab" aria-controls="unput" aria-selected="@if(my_goods_active(0)) true @else false @endif">
            预发布 @if(my_goods_active(0)) 【{{ $count }}】 @endif
          </a>
        </li>

        <li class="nav-item" role="presentation">
          <a class="nav-link @if(my_goods_active(1)) active @endif" id="check-tab" data-toggle="tab" href="#check" role="tab" aria-controls="check" aria-selected=" @if(my_goods_active(1)) true @else false @endif ">
            审核中 @if(my_goods_active(1)) 【{{ $count }}】 @endif
          </a>
        </li>

        <li class="nav-item" role="presentation">
          <a class="nav-link @if(my_goods_active(2)) active @endif" id="onsale-tab" data-toggle="tab" href="#onsale" role="tab" aria-controls="onsale" aria-selected="@if(my_goods_active(2)) true @else false @endif">
            出售中 @if(my_goods_active(2)) 【{{ $count }}】 @endif
          </a>
        </li>

        <li class="nav-item" role="presentation">
          <a class="nav-link @if(my_goods_active(3)) active @endif" id="booking-tab" data-toggle="tab" href="#booking" role="tab" aria-controls="booking" aria-selected="@if(my_goods_active(3)) true @else false @endif">
            预定中 @if(my_goods_active(3)) 【{{ $count }}】 @endif
          </a>
        </li>

        <li class="nav-item" role="presentation">
          <a class="nav-link @if(my_goods_active(4)) active @endif" id="alput-tab" data-toggle="tab" href="#alput" role="tab" aria-controls="alput" aria-selected="@if(my_goods_active(4)) true @else false @endif">
            已出售 @if(my_goods_active(4)) 【{{ $count }}】 @endif
          </a>
        </li>
      </ul>

      <!-- 未发布 -->
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane  @if(my_goods_active(0)) show active @else fade @endif " id="unput" role="tabpanel" aria-labelledby="unput-tab">
          <ul class="list-group list-group-flush" style="">
            @if(!Auth::user()->can('update_user_info', $user))
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  限制访问 ~_~
                </div>
              </div>
            @else

            @if(count($goods) > 0)
            {{-- <p style="display: none;">{{ $i=0 }}</p> --}}
            <?php $i = 0 ?>
            @foreach ($goods as $good => $value)
            @if($value->state == 0)

            <li class="list-group-item">
              <div class="row no-gutters">
                <div class="mt-2" style="">
                  <a href="{{ route('goods_detail', $value->id) }}" target='_blank' >
                    <img src="{{ $image[$i] }}" class="img-thumbnail" style="width: 100px; height:90px;" alt="...">
                    {{-- <p style="display: none;">{{$i++}}</p> --}}
                    <?php $i++ ?>
                  </a>

                </div>

                <div class="card-body" style="padding: 0.8rem;">
                  <h5 class="card-title">
                    <a href="{{ route('goods_detail', $value->id) }}" style="">{{ Str::limit($value->title,30,'...')
                      }}</a>
                  </h5>

                  <div class="mt-3">
                    <span class="" style="color: #d73038;height:25px;margin-bottom:0" title="售价">
                      ￥{{ $value->price }}元
                    </span>
                    <span class="ml-4">
                      <small title="{{ $value->created_at }}" class="text-muted">发布于
                        {{$value->created_at->diffForHumans() }}</small>
                    </span>
                  </div>

                  <div class="mt-1">
                    <!-- 浏览量 + 评论量 -->
                    <span class="card-text  mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px">
                      <i class="far fa-eye"></i> <span class="ml-1">{{$value->view_count}}</span>
                    </span>
                    <span class="card-text ml-2 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;">
                      <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->reply_count}}</span>
                    </span>

                  </div>
                </div>
                <div class="btn-group dropleft " style="height: 15px">
                  <!-- 编辑 -->
                  <div class="dropdown-menu mt-2 " style="width: 75px;min-width:0;padding:0;">
                    <a class="dropdown-item btn_edit" type="button" href="{{ route('edit_goods',$value->id) }}" target='_blank'>编辑</a>
                    <button value="{{ $value->id }}" class="dropdown-item btn_del" type="button" href="">删除</button>
                  </div>
                  <i class="fas fa-ellipsis-v edit_del " style="float:right;cursor:pointer;color:#636b6f"></i>
                </div>

              </div>
            </li>
            @endif
            @endforeach

            <li class="list-group-item">
              <div class="card-body">
                {!! $goods->render() !!}
              </div>
            </li>

            @else
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                暂无数据 ~_~
              </div>
            </div>
            @endif
            @endif
          </ul>
        </div>

        <!-- 审核中 -->
        <div class="tab-pane  @if(my_goods_active(1)) show active @else fade @endif " id="check" role="tabpanel" aria-labelledby="check-tab">
          <ul class="list-group list-group-flush">

            @if(!Auth::user()->can('update_user_info', $user))
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  限制访问 ~_~
                </div>
              </div>
            @else
            @if(count($user->goods) > 0)
            {{-- <p style="display: none;">{{ $i=0 }}</p> --}}
            <?php $i = 0 ?>
            @foreach ($goods as $good => $value)

            <li class="list-group-item">
              <div class="row no-gutters">
                <div class="mt-2" style="">
                  <a href="{{ route('goods_detail', $value->id) }}" target='_blank' >
                    <img src="{{ $image[$i] }}" class="img-thumbnail" style="width: 100px; height:90px;" alt="...">
                    {{-- <p style="display: none;">{{$i++}}</p> --}}
                    <?php $i++ ?>
                  </a>

                </div>

                <div class="card-body" style="padding: 0.8rem;">
                  <h5 class="card-title">
                    <a href="{{ route('goods_detail', $value->id) }}" style="">{{ Str::limit($value->title,30,'...') }}</a>
                  </h5>

                  <div class="mt-3">
                    <span class="" style="color: #d73038;hegiht:25px;margin-bottom:0" title="售价">
                      ￥{{ $value->price }}元
                    </span>
                    <span class="ml-4">
                      <small title="{{ $value->created_at }}" class="text-muted">发布于
                        {{$value->created_at->diffForHumans() }}</small>
                    </span>
                  </div>

                  <div class="mt-1">
                    <!-- 浏览量 + 评论量 -->
                    <span class="card-text  mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px">
                      <i class="far fa-eye"></i> <span class="ml-1">{{$value->view_count}}</span>
                    </span>
                    <span class="card-text ml-2 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;">
                      <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->reply_count}}</span>
                    </span>

                  </div>
                </div>
                <div class="btn-group dropleft " style="height: 15px">
                  <!-- 编辑 -->
                  <div class="dropdown-menu mt-2 " style="width: 75px;min-width:0;padding:0;">
                    <a class="dropdown-item btn_edit" type="button" href="{{ route('edit_goods',$value->id) }}" target='_blank' >编辑</a>
                    <button value="{{ $value->id }}" class="dropdown-item btn_del" type="button" href="">删除</button>
                  </div>
                  <i class="fas fa-ellipsis-v edit_del " style="float:right;cursor:pointer;color:#636b6f"></i>
                </div>

              </div>
            </li>
            @endforeach

            <li class="list-group-item">
              <div class="card-body">
                {!! $goods->render() !!}
              </div>
            </li>

            @else
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                暂无数据 ~_~
              </div>
            </div>
            @endif
            @endif
          </ul>
        </div>
                      
        <!-- 出售中 -->
        <div class="tab-pane @if(my_goods_active(2)) show active @else fade @endif" id="onsale" role="tabpanel" aria-labelledby="onsale-tab">
          <ul class="list-group list-group-flush">
            @if(!Auth::user()->can('update_user_info', $user) && !$user_visible->v_sale_goods)
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  限制访问 ~_~
                </div>
              </div>
            @else

            @if(count($user->goods) > 0)
            {{-- <p style="display: none;">{{ $i=0 }}</p> --}}
            <?php $i = 0 ?>
            @foreach ($goods as $good => $value)

            <li class="list-group-item">
              <div class="row no-gutters">
                <div class="mt-2" style="">
                  <a href="{{ route('goods_detail', $value->id) }}" target='_blank' >
                    <img src="{{ $image[$i] }}" class="img-thumbnail" style="width: 100px; height:90px;" alt="...">
                    {{-- <p style="display: none;">{{$i++}}</p> --}}
                    <?php $i++ ?>
                  </a>

                </div>

                <div class="card-body" style="padding: 0.8rem;">
                  <h5 class="card-title">
                    <a href="{{ route('goods_detail', $value->id) }}" style="">{{ Str::limit($value->title,30,'...')
                      }}</a>
                  </h5>

                  <div class="mt-3">
                    <span class="" style="color: #d73038;height:25px;margin-bottom:0" title="售价">
                      ￥{{ $value->price }}元
                    </span>
                    <span class="ml-4">
                      <small title="{{ $value->created_at }}" class="text-muted">发布于
                        {{$value->created_at->diffForHumans() }}</small>
                    </span>
                  </div>

                  <div class="mt-1">
                    <!-- 浏览量 + 评论量 -->
                    <span class="card-text  mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px">
                      <i class="far fa-eye"></i> <span class="ml-1">{{$value->view_count}}</span>
                    </span>
                    <span class="card-text ml-2 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;">
                      <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->reply_count}}</span>
                    </span>

                  </div>
                </div>
                @if(Auth::user()->can('update_user_info', $user))
                <div class="btn-group dropleft " style="height: 15px">
                  <!-- 编辑 -->
                  <div class="dropdown-menu mt-2 " style="width: 75px;min-width:0;padding:0;">
                    <a class="dropdown-item btn_edit" type="button" href="{{ route('edit_goods',$value->id) }}" target='_blank'>编辑</a>
                    <button value="{{ $value->id }}" class="dropdown-item btn_del" type="button" href="">删除</button>
                  </div>
                  <i class="fas fa-ellipsis-v edit_del " style="float:right;cursor:pointer;color:#636b6f"></i>
                </div>
                @endif
              </div>
            </li>
            @endforeach

            <li class="list-group-item">
              <div class="card-body">
                {!! $goods->render() !!}
              </div>
            </li>

            @else
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                暂无数据 ~_~
              </div>
            </div>
            @endif
            @endif
          </ul>
        </div>

        <!-- 已预订 -->
        <div class="tab-pane @if(my_goods_active(3)) show active @else fade @endif" id="booking" role="tabpanel" aria-labelledby="booking-tab">
          <ul class="list-group list-group-flush">
            @if(!Auth::user()->can('update_user_info', $user) && !$user_visible->v_booking_goods)
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  限制访问 ~_~
                </div>
              </div>
            @else

            @if(count($user->goods) > 0)
            {{-- <p style="display: none;">{{ $i=0 }}</p> --}}
            <?php $i = 0 ?>
            @foreach ($goods as $good => $value)

            <li class="list-group-item">
              <div class="row no-gutters">
                <div class="mt-2" style="">
                  <a href="{{ route('goods_detail', $value->id) }}" target='_blank' >
                    <img src="{{ $image[$i] }}" class="img-thumbnail" style="width: 100px; height:90px;" alt="...">
                    {{-- <p style="display: none;">{{$i++}}</p> --}}
                    <?php $i++ ?>
                  </a>

                </div>

                <div class="card-body" style="padding: 0.8rem;">
                  <h5 class="card-title">
                    <a href="{{ route('goods_detail', $value->id) }}" style="">{{ Str::limit($value->title,30,'...')
                      }}</a>
                  </h5>

                  <div class="mt-3">
                    <span class="" style="color: #d73038;height:25px;margin-bottom:0" title="售价">
                      ￥{{ $value->price }}元
                    </span>
                    <span class="ml-4">
                      <small title="{{ $value->created_at }}" class="text-muted">发布于
                        {{$value->created_at->diffForHumans() }}</small>
                    </span>
                  </div>

                  <div class="mt-1">
                    <!-- 浏览量 + 评论量 -->
                    <span class="card-text  mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px">
                      <i class="far fa-eye"></i> <span class="ml-1">{{$value->view_count}}</span>
                    </span>
                    <span class="card-text ml-2 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;">
                      <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->reply_count}}</span>
                    </span>

                  </div>
                </div>

                @if(Auth::user()->can('update_user_info', $user))
                <div class="btn-group dropleft " style="height: 15px">
                  <!-- 编辑 -->
                  <div class="dropdown-menu mt-2 " style="width: 75px;min-width:0;padding:0;">
                    <!-- <a class="dropdown-item btn_edit" type="button" href="" target='_blank'>编辑</a> -->
                    <button value="{{ $value->id }}" class="dropdown-item btn_del" type="button" href="">删除</button>
                  </div>
                  <i class="fas fa-ellipsis-v edit_del " style="float:right;cursor:pointer;color:#636b6f"></i>
                </div>
                @endif

              </div>
            </li>
            @endforeach

            <li class="list-group-item">
              <div class="card-body">
                {!! $goods->render() !!}
              </div>
            </li>

            @else
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                暂无数据 ~_~
              </div>
            </div>
            @endif
            @endif
          </ul>
        </div>

        <!-- 已出售 -->
        <div class="tab-pane @if(my_goods_active(4)) show active @else fade @endif" id="alput" role="tabpanel" aria-labelledby="alput-tab">
          <ul class="list-group list-group-flush">
            @if(!Auth::user()->can('update_user_info', $user) && !$user_visible->v_saled_goods)
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  限制访问 ~_~
                </div>
              </div>
            @else

            @if(count($goods) > 0)
            {{-- <p style="display: none;">{{ $i=0 }}</p> --}}
            <?php $i = 0 ?>
            @foreach ($goods as $good => $value)

            <li class="list-group-item">
              <div class="row no-gutters">
                <div class="mt-2" style="">
                  <a href="{{ route('goods_detail', $value->id) }}" target='_blank'>
                    <img src="{{ $image[$i] }}" class="img-thumbnail" style="width: 100px; height:90px;" alt="...">
                    {{-- <p style="display: none;">{{$i++}}</p> --}}
                    <?php $i++ ?>
                  </a>

                </div>

                <div class="card-body" style="padding: 0.8rem;">
                  <h5 class="card-title">
                    <a href="{{ route('goods_detail', $value->id) }}" style="">{{ Str::limit($value->title,30,'...')
                      }}</a>
                  </h5>

                  <div class="mt-3">
                    <span class="" style="color: #d73038;hegiht:25px;margin-bottom:0" title="售价">
                      ￥{{ $value->price }}元
                    </span>
                    <span class="ml-4">
                      <small title="{{ $value->created_at }}" class="text-muted">发布于
                        {{$value->created_at->diffForHumans() }}</small>
                    </span>
                  </div>

                  <div class="mt-1">
                    <!-- 浏览量 + 评论量 -->
                    <span class="card-text  mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px">
                      <i class="far fa-eye"></i> <span class="ml-1">{{$value->view_count}}</span>
                    </span>
                    <span class="card-text ml-2 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;">
                      <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->reply_count}}</span>
                    </span>

                  </div>
                </div>
                @if(!Auth::user()->can('update_user_info', $user))
                <div class="btn-group dropleft " style="height: 15px">
                  <!-- 编辑 -->
                  <div class="dropdown-menu mt-2 " style="width: 75px;min-width:0;padding:0;">
                    <!-- <a class="dropdown-item btn_edit" type="button" href="" target='_blank'>编辑</a> -->
                    <button value="{{ $value->id }}" class="dropdown-item btn_del" type="button" href="">删除</button>
                  </div>
                  <i class="fas fa-ellipsis-v edit_del " style="float:right;cursor:pointer;color:#636b6f"></i>
                </div>
                @endif
              </div>
            </li>
            @endforeach

            <li class="list-group-item">
              <div class="card-body">
                {!! $goods->render() !!}
              </div>
            </li>

            @else

            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                暂无数据 ~_~
              </div>
            </div>
            @endif
            @endif
          </ul>

        </div>

      </div>
    </div>
  </div>
</div>


@stop


@section('scriptsAfterJs')
<script>
  $(document).ready(function() {
    user_id=$('#user_id').val()

    // 商品状态-点击
    $('#unput-tab').click(function() { // 未发布
      window.location.href = "/users/"+user_id+"/sale_goods/0";
    })
    $('#check-tab').click(function() { // 审核ing
      window.location.href = "/users/"+user_id+"/sale_goods/1";
    })
    $('#onsale-tab').click(function() { //出售ing
      window.location.href = "/users/"+user_id+"/sale_goods/2";
    })
    $('#booking-tab').click(function() { // 预定
      window.location.href = "/users/"+user_id+"/sale_goods/3";
    })
    $('#alput-tab').click(function() { // 已出售
      window.location.href = "/users/"+user_id+"/sale_goods/4";
    })



    // 编辑图标-点击
    var this_btn
    $('.edit_del').click(function(e) {
      $(this).prev().toggleClass('show')
      this_btn = $(this)
      e.stopPropagation(); // 阻止冒泡

    })
    $(document).click(function() { //document点击-关闭菜单
      if (this_btn) {
        this_btn.trigger('click')
      }
      this_btn = null
    })

    // 删除按钮-点击
    $('.btn_del').click(function() {

      swal({
        title: '你确认要删除吗?',
        text: "此操作不可逆！",
        icon: 'warning',
        buttons: ['取消', '确定'],
        dangerMode: true,
      }).then((res) => {
        if (!res) {
          return;
        }
        var goods_id = $(this).val()
        console.log(goods_id)
        // 删除请求
        axios.delete('/ajax_del_gods/' + goods_id).then(function(res) {
          //console.log(res.data)
          swal('删除成功', '', 'success').then((res) => {
            location.reload();
          });

        }).then(function(error) {
          //swal('删除失败', '', 'error');
        })

      })
      $('.swal-text').addClass('danger_text'); // 样式-危险


    })





  })
</script>
@stop