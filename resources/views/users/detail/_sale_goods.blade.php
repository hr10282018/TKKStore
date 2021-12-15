<!-- 我的商品展示 -->
@extends('users.show')
@section('user_info')
<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;">

  <!-- <div class="card " style="height: 51px;">
      <div class="card-body" style="line-height:22px">
          <h1 class="mb-0" style="font-size:20px;line-height:12px">{{ $user->name }}，<small>最后活跃于：1天前</small></h1>
      </div>
    </div> -->

  <div class="card ">
    <ul class="list-group">
      <li class="list-group-item" style="">
        <div class="row mt-2 ">
          <i class="fas fa-store mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
          <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
            {{$user->name}}
            <span style="letter-spacing:2px">发布的商品</span>
            （0）
          </h1>
        </div>
      </li>
      @if(count($user->goods) > 0)
      <p style="display: none;">{{ $i=0 }}</p>
      @foreach ($goods as $good => $value)

      <li class="list-group-item">
        <div class="row no-gutters">
          <div class="">
            <a href="#">
              <img src="{{ $image[$i] }}" style="width: 100px; height:100px;" alt="...">
              <p style="display: none;">{{$i++}}</p>
            </a>
          </div>
          <div class=" ml-4" style="width: 500px;">

            <h5 class="card-title">
              <a href="">{{ $value->title }}</a>
            </h5>
            <p class="card-text" style="color: #d73038;" title="售价">￥：{{ $value->price }}元</p>
            <div class="row ">
              <p class="card-text"><small title="{{ $value->created_at }}" class="text-muted">发布于 {{ $value->created_at->diffForHumans() }}</small></p>

              <div class="" style="margin-left: 300px;">
                <a class="btn btn-primary"  style="width: 58px; height:29px;line-height:15px;">编辑</a>
                <form action="{{ route('delete_goods',$user->id) }}" method="post" onsubmit="return confirm('您确定要删除本条微博吗？');" class="float-right del_goods">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <input type="" name="goods_id" value="{{ $value->id }}" hidden>
                  <!-- <button type="submit" class="btn btn-sm btn-danger delete-btn ml-3 " data-toggle="modal" data-target="#staticBackdrop" style="width: 58px; height:29px;">删除</button> -->
                  <button type="submit" class="btn btn-sm btn-danger delete-btn ml-3 " style="width: 58px; height:29px;">删除</button>
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
        {!! $goods->render() !!}
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
