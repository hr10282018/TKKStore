@extends('layouts.app')
@section('title', '商品详情')

@section('content')

<div class="col-lg-10 offset-lg-1 " style="margin-bottom: 120px;">
  <div class="card ">
    <div class="card-body product-info ">

    @if( Auth::user()->id == $goods_info->user_id)
      @if($goods_info->state=='0')
      <div class="alert alert-info" role="alert" style="height: 40px;">
        <div class="" style="position:relative; top:-4px"> 
        预发布
        <img class="ml-3" src="/images/iconfont/private.png" title=" 仅你自己可见 " alt="" style="width:25px;height:25px;">
        </div>
      </div>
      @elseif($goods_info->state=='1')
      <div class="alert alert-info" role="alert" style="height: 40px;">
        <div class="" style="position:relative; top:-4px"> 
          审核中
          <img class="ml-3" src="/images/iconfont/private.png" title=" 仅你自己可见 " alt="" style="width:25px;height:25px;">
        </div>
      </div>
      @elseif($goods_info->state=='2')
      <div class="alert alert-info" role="alert" style="height: 40px;">
        <div class="" style="position:relative; top:-4px"> 
          出售中
          <img class="ml-3" src="/images/iconfont/private.png" title=" 所有人可见 " alt="" style="width:25px;height:25px;">
        </div>
      </div>
     
      @elseif($goods_info->state=='3')
      <div class="alert alert-info" role="alert" style="height: 40px;">
        <div class="" style="position:relative; top:-4px"> 
          预定中
          <img class="ml-3" src="/images/iconfont/private.png" title=" 所有人可见 " alt="" style="width:25px;height:25px;">
        </div>
      </div>
      @elseif($goods_info->state=='4')
      <div class="alert alert-info" role="alert" style="height: 40px;">
        <div class="" style="position:relative; top:-4px"> 
          已出售
          <img class="ml-3" src="/images/iconfont/private.png" title=" 所有人可见 " alt="" style="width:25px;height:25px;">
        </div>
      </div>

      @endif
    @endif

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
          <a href="{{ route('user_show', $user->id ) }}" target="_blank">
            <img src="{{ $user->avatar }}" class="img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
          </a>
          <a href="{{ route('user_show', $user->id ) }}" title="点击查看用户" class="mt-2 ml-2" style="text-decoration:underline;" target="_blank">
            <label for="" style="font-size:18px; ">{{ $user->name }}</label>
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
        

        <div class="row mt-3">
          {{-- 当前登录用户 是否 商品作者 --}}
          @if( Auth::user()->id == $goods_info->user_id)
           
            <div class="reply ml-3" style="color: rgb(99 ,107, 111);font-size:20px">
              @if($goods_info->state=='3')
                预定用户：
                <a href="{{ route('user_show', $booker->id ) }}" target="_blank">
                  <img src="{{ $booker->avatar }}" class="img-responsive img-circle" width="35px" height="35px" style="border-radius: 50%;">
                </a>
                <a href="{{ route('user_show', $booker->id ) }}" title="点击查看用户" class="mt-2 ml-2" style="text-decoration:underline;;" target="_blank">
                  <label for="" style="font-size:18px; ">{{ $booker->name  }}</label>
                </a>
              @elseif($goods_info->state=='4')
                购买用户：
                xxxxxxx
              @endif
            </div>

            @if($goods_info->state=='0' || $goods_info->state=='1' || $goods_info->state=='2')

            <a href="{{ route('edit_goods', $goods_info->id) }}" target="_blank">
              <button class="btn btn-success ml-3"><i class="far fa-edit"></i>
                编辑
              </button>
            </a>
            <button class="btn btn-danger ml-4  del_goods"><i class="fas fa-backspace"></i>
              删除
            </button>

            @elseif($goods_info->state=='3')
            <a href="" target="_blank">
              <button class="btn btn-primary ml-3 "><i class="fas fa-reply-all"></i>
                回复预定
              </button>
            </a>

            @elseif($goods_info->state=='4')
            <button class="btn btn-danger ml-3 del_goods"><i class="fas fa-backspace"></i>
              删除
            </button>
            @endif

          @else
            @if($goods_info->state=='2')
            <button class="btn btn-success btn-favor btn_booking" type="button" title="【每个商品用户仅限预定3次】">
              <i class="fas fa-heart"></i>
              预订
            </button>
            
            
            {{-- 预定中 --}}
            @elseif($goods_info->state=='3')    
              @if(isset($booker_login))      {{-- 当前登录为预定者 --}}
                @if($booker_login->user_state == 2)   {{-- 状态为预定中 --}}
                <button class="btn btn-danger btn-favor ml-3 btn_cancel_booking" type="button">
                  <i class="fas fa-heart"></i>
                    取消预定
                </button>
                @else
                <button class="btn btn-danger btn-favor ml-3" type="button" disabled>
                  <i class="fas fa-heart"></i>
                    预订中
                </button>
                @endif
              @else
              <button class="btn btn-danger btn-favor ml-3" type="button" disabled>
                  <i class="fas fa-heart"></i>
                    预订中
              </button>
              @endif
              @elseif($goods_info->state=='4')
                <button class="btn btn-dark btn-favor ml-3" type="button" disabled>
                  <i class="fas fa-heart"></i>
                    已出售
                </button>
             
            @endif
          @endif
        </div>


      </div>
    </div>

    <div class="product_detail mt-4">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link @if(!comment_tab()) active @endif" href="#product-detail-tab" aria-controls="product-detail-tab" role="tab" data-toggle="tab" aria-selected="@if(!comment_tab()) true @else false @endif">商品详情</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if(comment_tab()) active @endif" id="comment_url" href="#product-comment-tab" aria-controls="product-reviews-tab" role="tab" data-toggle="tab" aria-selected="@if(comment_tab()) true @else false @endif">商品评论</a>
        </li>
      </ul>
      <div class="tab-content">
        {{-- 详情 --}}
        <div role="tabpanel" class="tab-pane  @if(!comment_tab()) active @endif mt-3" id="product-detail-tab">
          <span class="mt-3 ml-3" style="font-size: 20px;">{{ $goods_info->description }}</span>
        </div>

        {{-- 评论 --}}
        <div role="tabpanel" class="tab-pane  @if(comment_tab()) active @endif" id="product-comment-tab">
          <ul class="list-group list-group-flush">

            <li class="list-group-item">
              <div class="reply-box">
                <form class="form_comment" action="{{ route( 'goods_comment' ,$goods_info->id ) }}" method="POST" accept-charset="UTF-8">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <!-- <input type="hidden" name="goods_id" value="{{ $goods_info->id }}"> -->
                  <div class="form-group">
                    <textarea class="form-control content" rows="3" maxlength="255" style="height:52px;max-height: 150px;min-height: 130px;" placeholder="快来分享你的想法~" name="content"></textarea>
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
            @if(count($comments) > 0)
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
                      <input type="hidden" name="goods_id" value="{{ $goods_info->id }}">
                      <input type="hidden" name="goods_id" value="{{ $value->id }}">
                      <button type="button" title="删除" class="btn btn-default btn-xs pull-left text-secondary del_comment">
                        <i class="far fa-trash-alt"></i>
                      </button>
                    </span>
                    @endcan

                  </div>
                </div>
              </div>

              <div id="comment-{{ $value->id }}" class="reply-content text-secondary " style="position:relative;bottom:23px;margin-left:48px;font-size:17px;">
                {{ $value->content }}
              </div>

            </li>
            @endforeach
            <li class="list-group-item">
              <div class="card-body">
                {!! $comments->appends(Request::except('page'))->render() !!}
              </div>
            </li>
            @else
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                暂无评论 ~_~
              </div>
            </div>

            @endif
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
  $(document).ready(function() {

    // 跳转
    $('#comment_url').click(function() {
      console.log(window.location.href + '&tab=comments')
      if (window.location.href.indexOf('tab=comments') < 0) {
        if (window.location.href.indexOf('?') < 0) {
          window.location.href = window.location.href + '?tab=comments'
        } else {
          window.location.href = window.location.href + '&tab=comments'
        }
      } else {
        window.location.href = window.location.href
      }

    })

    $('.btn_comment').click(function() {
      // 加载样式

      if ($('.content').val().length <= 0) {
        swal({
          text: '请至少输入一个字符 ^_^',
          icon: 'warning'
        })
      } else {
        $(this).attr('disabled', 'true')
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  Loading...')
        $('.form_comment').submit()
      }
    })

    // 作者删除商品
    $('.del_goods').click(function(){
      console.log('del');
      swal({
        title: '你确认要删除吗?',
        text: "此操作不可逆！",
        icon: 'warning',
        buttons: ['取消', '确定'],
        dangerMode: true,
      }).then( (res) => {
        if(!res){
          return;
        }
        // 删除请求
        axios.delete('{{ route('del_goods_ajax', ['goods' => $goods_info->id]) }}').then(function(res){
          //console.log(res.data)
          swal('删除成功', '', 'success').then((res) => {
            //$goods_info
            location.href='{{ route('sale_goods', ['user' => Auth::user()->id,'state' => $goods_info->state]) }}';
          });
        }).then(function(error) {
          if (error.response.status === 404) {
            swal('删除失败', '', 'error');
          }
          //swal('删除失败', '', 'error');
        })

      })

      $('.swal-text').addClass('danger_text'); // 样式-危险
    })


    // 删除评论
    $('.del_comment').click(function() {
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

        // 删除请求
        comments_id=$(this).prev().val();
        goods_id=$(this).prev().prev().val();

        axios.delete('/goods/'+goods_id+'/'+comments_id+'/delete').then(function(res) {
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

    var booking_count
    function getBookingCount(){
        axios.get('{{ route('ajax_booking_count',['goods' => $goods_info->id] ) }}').then((res) => {
        booking_count=res.data
      },function(error){
        console.log('error')
      })
    }
    getBookingCount();    // 预定次数
    // 预定商品
     $('.btn_booking').click(function(){
      //console.log(1)
      
      console.log(booking_count)
      if(booking_count >= 3){
        swal({
          title: '预定失败！',
          text: "你已经预定该商品3次，无法再预定！",
          icon: 'error',
        })
        $('.swal-text').addClass('danger_text'); // 样式-危险
      }else{
        count=3-booking_count
        swal({
        title: '你确认要预定吗?',
        text: "你还可以预定此商品 "+count+" 次！",
        icon: 'info',
        buttons: ['取消', '确定'],
        
        }).then((res) => {
          if (!res) {
            return;
          }
          axios.post('{{ route('ajax_booking_goods',['goods' => $goods_info->id, 'user_id' =>$goods_info->user_id ]) }}').then(function(res){
            console.log(res.data)
            swal('预定成功', '', 'success').then((res) => {
              location.reload();
            });
          })
        })

        $('.swal-text').addClass('info_text'); // 样式-info
      }
    })
    
    
    // 取消预定
    $('.btn_cancel_booking').click(function(){
      swal({
        title: '你确认要取消吗?',
        text: "",
        icon: 'warning',
        buttons: ['取消', '确定'],
        dangerMode: true,
      }).then((res)=>{
        if(!res){
          return;
        }
        axios.delete('{{ route('ajax_cancel_booking',['goods' => $goods_info->id]) }}').then(function(res){
          console.log(res.data)
          swal('取消预定成功！', '', 'success').then((res) => {
            location.reload();
          });
        },function(error){

        })
      })

    })

  })
</script>
@stop