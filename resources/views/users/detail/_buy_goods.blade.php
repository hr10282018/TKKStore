<!-- 购买商品 -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;">
  <div class="card mb-5">
    <div class="card-body">
      <div class="row mt-2 ">
        <i class="fas fa-store mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
        <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
          {{$user->name}}
          <span style="letter-spacing:2px">订购的商品</span>
          （110）
        </h1>
      </div>
    </div>

    <hr style="width: 650px;margin:0 auto;">

    <div class="card-body">
      {{-- 商品状态导航 --}}
      <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link @if(my_goods_active(0)) active @endif" id="booking-tab" data-toggle="tab" href="#booking" role="tab" aria-controls="booking" aria-selected="@if(my_goods_active(0)) true @else false @endif">
            已预定 【12】
          </a>
        </li>

        <li class="nav-item" role="presentation">
          <a class="nav-link @if(my_goods_active(1)) active @endif" id="check-tab" data-toggle="tab" href="#check" role="tab" aria-controls="check" aria-selected=" @if(my_goods_active(1)) true @else false @endif ">
            已购买 【12】
          </a>
        </li>
      </ul>

      <div class="tab-content" id="myTabContent">
        <div class="tab-pane  @if(my_goods_active(0)) show active @else fade @endif " id="booking" role="tabpanel" aria-labelledby="booking-tab">
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
                  <a href="{{ route('goods_detail', $value->id) }}">
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

                <div class="btn-group dropleft " style="height: 15px">  <!-- 编辑 -->
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



      </div>



      @stop