@extends('layouts.app')
@section('title', '商品详情')

@section('content')

<div class="col-lg-10 offset-lg-1 " style="margin-bottom: 120px;">
  <div class="card " >
    <div class="card-body product-info " >
      <div class="row">
        <!-- 商品轮播图 -->
        <div class="col-5">

          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              @if($length>1)
              @for ($i = 1; $i < $length; $i++) <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}">
                </li>
                @endfor
                @endif
            </ol>

            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{ $images[0] }}" style="width: 400px;" class="d-block w-100" alt="...">
              </div>

              @if($length>1)
              @for ($i = 1; $i < $length; $i++) <div class="carousel-item ">
                <img src="{{ $images[$i] }}" style="width: 400px;" class="d-block w-100" alt="...">
            </div>
            @endfor
            @endif
          </div>

          <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </button>

        </div>
      </div>

      <!-- 商品右侧 -->
      <div class="col-6 ml-3">
        <div class="row">
          <a href="{{ route('user_show', $user->id ) }}">
            <img src="{{ $user->avatar }}" class="img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
          </a>
          <a href="{{ route('user_show', $user->id ) }}" title="点击查看用户" class="mt-2 ml-2" style="text-decoration:underline">
            <label for="" style="font-size:18px">{{ $user->name }}</label>
          </a>

        </div>
        <div class="title mt-3">
          <h3 style="font-weight: 510;">{{ $goods_info->title }}</h3>
        </div>

        <div class="lags  " style="color: rgb(99 ,107, 111);margin-top:25px;line-height:25px">
          <!-- <i class="fas fa-tags " style="color: rgb(99 ,107, 111); font-size:20px;"></i> -->
          <img src="/images/iconfont/tag.png" alt="" style="width: 27px;height:27px">

          @if(sizeof($tags_data) != 0)
            @foreach($tags_data as $tag => $value)
              <button type="button" class="btn btn_tag ml-2" style="outline:none;line-height:15px;height:27px;border-color:  #91d5ff; background: #e6f7ff;font-size: 12px;color: #1890ff">
              {{ $value->name }}
              </button>
            @endforeach
          @else
            <span class="ml-2">无卖家标签 ^_^</span>
          @endif
        </div>

        <div class="price mt-3">
          <i class="fas fa-money-check-alt" style="color: rgb(99 ,107, 111); font-size:18px;">
          </i>
          <label class="ml-2" style="font-weight:400;color: red;font-size:17px;color:rgb(189 ,45, 48);">
            <em>￥</em>
            <span>{{ $goods_info->price }}元</span>
            <span class="ml-2" style="font-size:15px;color:#a5a5a5;">原价 {{ $goods_info->old_price }}元</span>
          </label>
        </div>

        <!-- <div id="state" class="mt-2" style="color: rgb(99 ,107, 111);">
          <i class="far fa-clock" style="font-size: 20px;"></i>
          <span class="ml-2" title="">正在出售</span>
        </div> -->

        <div id="time" class="mt-2" style="color: rgb(99 ,107, 111);">
          <i class="far fa-clock" style="font-size: 20px;"></i>
          <span class="ml-3" title="{{ $goods_info->created_at }}">{{ $goods_info->created_at->diffForHumans() }}</span>
        </div>

        <div id="view" class="mt-3" style="color: rgb(99 ,107, 111);">
          <i class="far fa-eye" style="font-size: 20px;"></i>
          <span class="ml-3" style="font-size: 15px;">浏览 {{ $goods_info->view_count }}</span>
        </div>

        <div class="reply mt-3" style="color: rgb(99 ,107, 111);">
          <i class="far fa-comment" style="font-size: 20px;"></i>
          <span class="ml-3" style="font-size: 15px;">评论 {{ $goods_info->reply_count }}</span>
        </div>

        <div class="row mt-4">
          @if( Auth::user()->id != $goods_info->user_id)

          @if($goods_info->state=='1')
          <form action="{{ route('booking_goods', $goods_info->id) }}" method="POST" accept-charset="UTF-8" onsubmit="return confirm('预定后一天之内无法取消预订，确定要预订吗？');">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="user_id" value="{{ $goods_info->user_id }}">
            <button class="btn btn-success btn-favor" type="submit">
              <i class="fas fa-heart" ></i>
              预订
            </button>

          </form>
          <button class="btn btn-primary btn-add-to-cart ml-3">加入收藏</button>

          @elseif($goods_info->state=='2')
          <button class="btn btn-danger btn-favor" disabled>
            <i class="fas fa-heart" style="color:red"></i>
            已被预订
          </button>
          <button class="btn btn-primary btn-add-to-cart ml-3">加入收藏</button>
          @else($goods_info->state=='3')
          <button class="btn btn-secondary btn-favor" disabled>
            <i class="fas fa-heart" style="color:#a5a5a5;"></i>

            已出售
          </button>
          @endif

          @else
          <button class="btn btn-success btn-favor" >
            <i class="far fa-edit" ></i>

            编辑
          </button>



          @endif

        </div>

      </div>
    </div>

    <div class="product_detail mt-4">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" href="#product-detail-tab" aria-controls="product-detail-tab" role="tab" data-toggle="tab" aria-selected="true">商品详情</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#product-reviews-tab" aria-controls="product-reviews-tab" role="tab" data-toggle="tab" aria-selected="false">商品评论</a>
        </li>
      </ul>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active mt-3" id="product-detail-tab">
          <span class="mt-3 ml-3" style="font-size: 20px;">{{ $goods_info->description }}</span>
        </div>

        <div role="tabpanel" class="tab-pane" id="product-reviews-tab">
          <ul class="list-group list-group-flush">

            <li class="list-group-item">
              <div class="reply-box">
                <form class="form_comment" action="{{ route( 'goods_comment' ,$goods_info->id ) }}" method="POST" accept-charset="UTF-8">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <!-- <input type="hidden" name="goods_id" value="{{ $goods_info->id }}"> -->
                  <div class="form-group">
                    <textarea class="form-control" rows="3" style="height:52px;max-height: 150px;min-height: 130px;" placeholder="快来分享你的想法~" name="content" required></textarea>
                  </div>
                  <button type="button" class="btn btn-primary btn-sm btn_comment">
                    <i class="fa fa-share mr-1"></i>参与讨论
                  </button>

                  <!-- <button class="btn btn-primary btn-sm" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                  </button> -->

                </form>
              </div>
            </li>

            @foreach($comments as $comment=>$value)
            <li class="list-group-item mt-2">
              <div class=" row ">
                <a href="{{ route('user_show', $value->user_id) }}">
                  <img src="{{ $value->user->avatar }}" alt="{{ $value->user->name }}" class="img-thumbnail img-responsive img-circle" width="55px" height="55px" style="border-radius: 50%;">
                </a>

                <div class="media-body">
                  <div class="media-heading mt-1 ml-2 text-secondary">
                    <a href="{{ route('user_show', $value->user_id) }}" title="">
                    {{ $value->user->name }}
                    </a>
                    <span class="text-secondary"> • </span>
                    <span class="meta text-secondary" title="{{  $value->created_at }}">{{ $value->created_at->diffForHumans() }}</span>

                    @can('delete_comment',$value,$goods_info)
                    <span class="meta float-right ">
                      <form action="{{ route( 'delete_comment' ,$value->id ) }}" onsubmit="return confirm('确定要删除此评论？');" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="goods_id" value="{{ $goods_info->id }}">
                        <button type="submit" title="删除" class="btn btn-default btn-xs pull-left text-secondary">
                          <i class="far fa-trash-alt"></i>
                        </button>
                      </form>
                    </span>
                    @endcan
                  </div>
                </div>
              </div>

              <div class="reply-content text-secondary " style="position:relative;bottom:23px;margin-left:48px;font-size:17px;" >
                {{ $value->content }}
              </div>

            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
@endsection

@section('scriptsAfterJs')
<script>
  $(document).ready(function(){
    $('.btn_comment').click(function(){

      // 加载样式
      $(this).attr('disabled','true')
      $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  Loading...')
      $('.form_comment').submit()
    })

  })
</script>
@stop
