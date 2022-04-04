

<!-- 预订通知展示 -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;">
  <div class="card ">
    <ul class="list-group">
      <li class="list-group-item" >
        <div class="row mt-2 ">

          <i class="far fa-envelope mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
          <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
            {{ $user->name }}
            <span style="letter-spacing:2px">预订通知</span>
            （{{ count($bookings) }}）
          </h1>

          <div  class="mt-2" style="margin-left: 250px;">
          <a href="">待处理</a>
          <a href="">已处理</a>

          </div>

        </div>
      </li>

      @if( count($bookings) > 0 )
      @foreach ($bookings as $book => $value)
      <li class="list-group-item">
        <div class="row no-gutters">
          <div class="">
            <a href="{{ route('goods_detail', $value->goods_id) }}">
              <img src="{{ Str::before($value->goods->image,',') }}" style="width: 100px; height:100px;" alt="...">
            </a>
          </div>
          <div class=" ml-3" style="width: 500px;">

            <!-- <h5 class="card-title">
              <a href="{{ route('goods_detail', $value->id) }}">{{ $value->goods->title }}</a>
            </h5> -->
            <!-- <span>接受预订</span> -->
            <div class="mt-4">
            <a href="{{ route('user_show', $value->user_id) }}">
                <img src="{{ $value->user->avatar }}" alt="{{ $value->user->name }}" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
            </a>
              <a href="">{{ $value->buyer->name }}</a>  向你发送了商品预订请求，请尽快处理！
            </div>


            <div class=" mt-3 ml-0">
              <p class="card-text"><small title="{{ $value->created_at }}" class="text-muted">预订于 {{ $value->created_at->diffForHumans() }}</small></p>

              <div class="" style="margin-left: 280px;">
                <!-- <a class="btn btn-primary"  style="width: 58px; height:29px;line-height:15px;">接受</a> -->

                <form action="{{ route('refuse_booking',array($user->id,$value->id)) }}" method="post" onsubmit="return confirm('您确定吗？');" class="float-right del_goods">
                  {{ csrf_field() }}

                  <input type="" name="goods_id" value="{{ $value->id }}" hidden>
                  <button type="submit" class="btn btn-sm btn-outline-danger delete-btn ml-3 " style="width: 58px; height:29px;">拒绝</button>
                </form>

                <form action="{{ route('agree_booking',array($user->id,$value->id)) }}" method="post" onsubmit="return confirm('？');" class="float-right del_goods">
                  {{ csrf_field() }}
                  @method('PUT')
                  <input type="" name="goods_id" value="{{ $value->id }}" hidden>
                  <button type="submit" class="btn btn-sm btn-outline-success delete-btn ml-3 " style="width: 58px; height:29px;">接受</button>
                </form>

                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        你确定要删除该商品吗？此操作不可逆！
                      </div>
                      <div class="modal-footer del_goods_btn">
                        <button type="button" class="btn btn-secondary no" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary yes">确定</button>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>
      </li>
      @endforeach
      <div class="card-body">
        {!! $bookings->render() !!}
      </div>
    </ul>

    @else
    <div class="card-body">
      <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
        暂无数据 ~_~
      </div>
    </div>
    @endif


  </div>
</div>

@stop
