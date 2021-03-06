

<!-- 订购商品  -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;margin-bottom:75px">
  <div class="card ">
    <div class="card-body">
      <div class="row ">
        <i class="far fa-envelope mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
        <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
          {{ $user->name }}
          <span style="letter-spacing:2px"> 订购商品</span>
          @if(!Auth::user()->can('update_user_info', $user) && (!$user_visible->v_buy_booking_goods || !$user_visible->v_buy_sale_goods))

          （*）
          @else
          （{{ $booking_goods_count+$buy_goods_count }}）
          @endif
        </h1>
      </div>

     

    </div>

    <hr style="width: 650px;margin:0 auto;">

    <div class="card-body ">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item booking" role="presentation">
          <a class="nav-link @if(booking_buy_active('booking')) active @endif " id="booking-tab" data-toggle="tab" href="#booking" role="tab" aria-controls="booking" aria-selected="@if(booking_buy_active('booking')) true @else false @endif">
            预定 
            @if(booking_buy_active('booking')) 
              @if(!Auth::user()->can('update_user_info', $user) && !$user_visible->v_buy_booking_goods)
              【*】
              @else
              【{{ $booking_goods_count }}】
              @endif
            @endif
            
          </a>
        </li>
        <li class="nav-item buy" role="presentation">
          <a class="nav-link @if(booking_buy_active('buy')) active @endif" id="buy-tab" data-toggle="tab" href="#buy" role="tab" aria-controls="buy" aria-selected="@if(booking_buy_active('buy')) true @else false @endif">
            已购 
            @if(booking_buy_active('buy')) 
              @if(!Auth::user()->can('update_user_info', $user) && !$user_visible->v_buy_sale_goods)
              【*】
              @else
              【{{ $buy_goods_count }}】
              @endif
            @endif
            
          </a>
        </li>
      </ul>

      <input type="text" value="{{ $booking_goods_count/5 }}" name="" id="booking_goods_count" hidden>   <!-- 预定页数-->
      <input type="text" value="{{ $buy_goods_count/5 }}" name="" id="buy_goods_count" hidden>   <!-- 购买页数-->


        
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade @if(booking_buy_active('booking')) show active @endif" id="booking" role="tabpanel" aria-labelledby="booking-tab">
          <ul class="list-group list-group-flush">
            @if(!Auth::user()->can('update_user_info', $user) && !$user_visible->v_buy_booking_goods)
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  限制访问 ~_~
                </div>
              </div>
            @else

              @if( count($booking_goods) > 0 )
              @foreach ($booking_goods as $goods => $value)
                
                <li class="list-group-item">
                  <div class="row no-gutters">
                    <div class="">
                      <a href="{{ route('goods_detail',$value->goods->id) }}" target="_blank">
                        <img src="{{ $value->goods->image[0] }}" style="width: 100px; height:100px;" alt="...">
                      </a>
                    </div>

                    <div class="card-body" style="padding: 0.8rem;">
                      <h5 class="card-title">
                        <a href="{{ route('goods_detail', $value->goods->id) }}" style="">{{ Str::limit($value->goods->title,30,'...')}}</a>
                      </h5>

                      <div class="mt-3">
                        <span class="" style="color: #d73038;height:25px;margin-bottom:0" title="售价">
                          ￥{{ $value->goods->price }}元
                        </span>
                        <span class="ml-4">
                          <small title="{{ $value->goods->created_at }}" class="text-muted">发布于
                            {{ $value->goods->created_at->diffForHumans() }}
                            
                          </small>
                        </span>

                        <span class="ml-4">
                          <small title="最近一次预定：{{ $value->created_at }}" class="text-muted">预定于
                            {{ $value->created_at->diffForHumans()}}
                          </small>
                        </span>
                      </div>

                      <div class="mt-1">
                        <!-- 浏览量 + 评论量 + 预定次数-->
                        <span class="card-text  mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px" title="浏览量">
                          <i class="far fa-eye"></i> <span class="ml-1">{{$value->goods->view_count}}</span>
                        </span>
                        <span class="card-text ml-2 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;" title="评论量">
                          <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->goods->reply_count}}</span>
                        </span>
                        <span class="card-text ml-2 mt-1 mr-1 booking_count" style="position:relative; font-size:12px; left:0px;" title="预定次数">
                          <i class="fas fa-history"></i> <span class="ml-1">{{$value->booking_count}}</span>
                        </span>
                        
                      </div>
                    </div>

                  </div>
                </li>
              @endforeach
              <div class="card-body">
                {!! $booking_goods->appends(Request::except('page'))->render() !!}
              </div>
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

        {{-- 购买 --}}
        <div class="tab-pane fade @if(booking_buy_active('buy')) show active @endif" id="buy" role="tabpanel" aria-labelledby="buy-tab">
          <ul class="list-group list-group-flush">
            @if(!Auth::user()->can('update_user_info', $user) && !$user_visible->v_buy_sale_goods)
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  限制访问 ~_~
                </div>
              </div>
            @else

              @if( count($buy_goods) > 0 )
              @foreach ($buy_goods as $goods => $value)
                @if($value->goods->state == 4)    {{--  只显示 已出售(成功交易) --}}
                <li class="list-group-item">
                  <div class="row no-gutters">
                    <div class="">
                      <a href="{{ route('goods_detail',$value->goods->id) }}" target="_blank">
                        <img src="{{ $value->goods->image[0] }}" style="width: 100px; height:100px;" alt="...">
                      </a>
                    </div>

                    <div class="card-body" style="padding: 0.8rem;">
                      <h5 class="card-title">
                        <a href="{{ route('goods_detail', $value->goods->id) }}" style="">{{ Str::limit($value->goods->title,30,'...')}}</a>
                      </h5>

                      <div class="mt-3">
                        <span class="" style="color: #d73038;height:25px;margin-bottom:0" title="售价">
                          ￥{{ $value->goods->price }}元
                        </span>
                        <span class="ml-4">
                          <small title="{{ $value->goods->created_at }}" class="text-muted">发布于
                            {{ $value->goods->created_at->diffForHumans() }}
                            
                          </small>
                        </span>

                        <span class="ml-4">
                          <small title="最近一次预定：{{ $value->created_at }}" class="text-muted">购买于
                            {{ $value->created_at->diffForHumans()}}
                          </small>
                        </span>
                      </div>

                      <div class="mt-1">
                        <!-- 浏览量 + 评论量 + 预定次数-->
                        <span class="card-text  mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px" title="浏览量">
                          <i class="far fa-eye"></i> <span class="ml-1">{{$value->goods->view_count}}</span>
                        </span>
                        <span class="card-text ml-2 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;" title="评论量">
                          <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->goods->reply_count}}</span>
                        </span>
                       
                        
                      </div>
                    </div>

                  </div>
                </li>
                @endif
              @endforeach
              <div class="card-body">
                {!! $buy_goods->appends(Request::except('page'))->render() !!}
              </div>
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
<script src="https://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<script src="/js/dist/js/bootstrap-datepicker.min.js"></script>
<script src="/js/dist/locales/bootstrap-datepicker.zh-CN.min.js" charset="UTF-8"></script>

<script>
  $(document).ready(function() {
    var old_tail_url=[]   // 记录之前状态 -页数
    var lastPage=Math.ceil($('#booking_goods_count').val())  // 获取 预定最后一页
    var lastPage_yesReply=Math.ceil($('#buy_goods_count').val())  // 获取 购买最后一页

    if (lastPage==0) lastPage=1
    if (lastPage_yesReply==0) lastPage_yesReply=1

    var now_url_page=window.location.href.split('page=')[1]    // 获取当前页
    if(now_url_page == undefined) now_url_page=1

    //console.log(document.referrer)

    if(document.referrer.indexOf('buy_goods') == -1 && document.referrer.length != 0){   // 当跳转不存在页数，referrer为空,此时也为刷新
      console.log('跳转')
      old_tail_url=['type=booking','type=buy']
      
      $.removeCookie('buy_goods_booking_old_url')
      $.removeCookie('buy_goods_buy_old_url')
    }else{
      console.log('刷新')
      // 
      
      if(!$.cookie('buy_goods_booking_old_url')){
        no_reply='type=booking'
      }else{
        if(window.location.href.indexOf('type=booking') != -1 ){   // 当前页面是待回复页面，则需要判断以下-page问题
          // 判断 待回复页数是否为0，且url为待回复
          if(now_url_page > lastPage){  //      最后一页问题-如果取消预定一个商品刚好没有下一页，而用户点了下一页，则改页数据为空，需返回第1页
            $.removeCookie('buy_goods_booking_old_url')
            no_reply='type=booking'
          }else if(now_url_page <= lastPage){
            no_reply=$.cookie('buy_goods_booking_old_url')
          }
        }else{
          no_reply=$.cookie('buy_goods_booking_old_url')
        }
        
      }
      if(!$.cookie('buy_goods_buy_old_url')){
        yes_reply='type=buy'
      }else{
        if(window.location.href.indexOf('type=buy') != -1){   // 当前页面是已回复页面，则需要判断以下-page问题
          // 判断 已回复页数是否为0，且url为待回复
          if(now_url_page > lastPage_yesReply){  //      最后一页问题-如果取消预定一个商品刚好没有下一页，而用户点了下一页，则改页数据为空，需返回第1页
            $.removeCookie('buy_goods_buy_old_url')
            yes_reply='type=buy'
          }else if(now_url_page <= lastPage_yesReply){
            yes_reply=$.cookie('buy_goods_buy_old_url')
          }
        }else{
          yes_reply=$.cookie('buy_goods_buy_old_url')
        }
        
      }
    
      old_tail_url=[no_reply,yes_reply]
      //console.log(old_tail_url)
    }
    
    // 待回复 -点击
    $('.booking').click(function(){
      
      now_url=window.location.href

      index=now_url.indexOf("type")
      head=now_url.substring(0,index)

      window.location.href=head+old_tail_url[0]
      //console.log(old_tail_url[0])
      //console.log(now_url.substring(index))
    })
    $('.buy').click(function(){
      now_url=window.location.href

      index=now_url.indexOf("type")
      head=now_url.substring(0,index)
      window.location.href=head+old_tail_url[1]
    })

    // 页数跳转-点击
    $('a.page-link').click(function(){
      next_url=$(this).attr('href')
      index=next_url.indexOf("type")
      tail=next_url.substring(index)
      //var reply_expire= new Date();
      //reply_expire.setTime(expiresDate.getTime() + (60*1000));   // 2小时

      if(window.location.href.indexOf("type=booking") != -1){
        $.cookie('buy_goods_booking_old_url', tail);
      }else if((window.location.href.indexOf("type=buy") != -1)){
        $.cookie('buy_goods_buy_old_url', tail)
      }
    })


    
    
  })

</script>

@stop