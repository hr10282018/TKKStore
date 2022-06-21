<!-- 我的预订展示 -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;margin-bottom:75px">
  <div class="card ">

    <div class="card-body">
      <div class="row ">
        <i class="far fa-envelope mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
        <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
         {{ $user->name }}
          <span style="letter-spacing:2px">的预订</span>
          @if(!Auth::user()->can('update_user_info', $user))
          （*）
          @else
          （{{ count($user->bookings) }}）
          @endif
        </h1>
      </div>
    </div>

    <hr style="width: 650px;margin:0 auto;">

    <div class="card-body ">
      <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item no_reply" role="presentation">
          <a class="nav-link @if(reply_acyive('no')) active @endif " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected=" @if(reply_acyive('no')) true @else false @endif">
            待回复 
            @if(reply_acyive('no')) 
              @if(!Auth::user()->can('update_user_info', $user))
              【*】
              @else
              【{{ $no_reply_count }}】 
              @endif
            @endif
            
          </a>
        </li>
        <li class="nav-item yes_reply" role="presentation">
          <a class="nav-link @if(reply_acyive('yes')) active @endif" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="@if(reply_acyive('yes')) true @else false @endif">
            已回复 
            @if(reply_acyive('yes'))
             @if(!Auth::user()->can('update_user_info', $user))
              【*】
              @else
              【{{ $yes_reply_count }}】
              @endif
            @endif

          </a>
        </li>
      </ul>

      <input type="text" value="{{ $no_reply_count/5 }}" name="" id="no_reply_count" hidden>   <!-- 待回复页数 -->
      <input type="text" value="{{ $yes_reply_count/5 }}" name="" id="yes_reply_count" hidden>   <!-- 已回复页数-->

      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade  @if(reply_acyive('no')) show active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
          <ul class="list-group list-group-flush">
            @if(!Auth::user()->can('update_user_info', $user))
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  限制访问 ~_~
                </div>
              </div>
            @else

              @if( count($no_reply_booking) > 0 )
              @foreach ($no_reply_booking as $booking => $value)
              <li class="list-group-item">
                <div class="row no-gutters">

                  <div class="">
                    <a href="{{ route('goods_detail',$value->goods->id ) }}" target="_blank">
                      <img src="{{ $value->goods->image[0] }}" style="width: 100px; height:100px;" alt="...">
                    </a>
                  </div>
                  <div class="ml-2" >
                    <div class="mt-4">
                      <a href="{{ route('user_show' , $value->user->id) }}">
                        <img src="{{ $value->user->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                      </a>
                      <a href="{{ route('user_show' , $value->user->id) }}">{{ $value->user->name }}</a>  <span style="color:#636b6f">【未回复】</span> 你的预订！
                    </div>
                    <div class="card-text mt-1 ml-3"><small title="{{ $value->created_at }}" class="text-muted">预订于 {{ $value->created_at->diffForHumans() }}</small></div>
                  </div>
                </div>
              </li>
              @endforeach
              <div class="card-body">
              
                {!! $no_reply_booking->appends(Request::except('page'))->render() !!}
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
        
        <div class="tab-pane fade @if(reply_acyive('yes')) show active @endif" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <ul class="list-group list-group-flush">
            @if(!Auth::user()->can('update_user_info', $user))
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  限制访问 ~_~
                </div>
              </div>
            @else

            @if( count($yes_reply_booking) > 0 )
            @foreach ($yes_reply_booking as $booking => $value)
            <li class="list-group-item">
              <div class="row no-gutters">
                <div class="">
                  <a href="{{ route('goods_detail',$value->goods->id ) }}">
                    <img src="{{ $value->goods->image[0] }}" style="width: 100px; height:100px;" alt="...">
                  </a>
                </div>
                <div class="ml-2" >
                  <div class="mt-4">
                    
                    @if($value->user_state=='0' || $value->user_state=='1')
                      <a href="{{ route('user_show' , $value->user->id) }}" target="_blank">
                        <img src="{{ $value->user->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                      </a>
                      <a href="{{ route('user_show' , $value->user->id) }}" target="_blank">{{ $value->user->name }}</a>
                      <span style="color:{{ ($value->user_state=='1') ? 'green':'red'  }};">{{ ($value->user_state=='1') ? '【同意】':'【拒绝】' }}</span> 你的预订
                      @if($value->user_state == '1')
                        ，请注意查收 <a href="#">订单</a> ！
                      @else
                      ！
                      @endif

                    @elseif($value->user_state=='3')
                      <a href="{{ route('user_show' , $user->id) }}" target="_blank">
                        <img src="{{ $user->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                      </a>
                      <a href="{{ route('user_show' , $user->id) }}" target="_blank">{{ $user->name }}</a>
                      <span style="color:#636b6f">【取消】</span> 预定！
                    @endif
                  </div>

                  <div class="ml-2 mt-1 ">
                    @if($value->user_state=='0') 
                      <span style="font-size: 12px;color:#d39e00">【拒绝原因】：</span> 
                      <span style="color: #636b6f;font-size: 11px;font-weight:bold">{{ $value->reason }}</span>
                    @endif
                  </div>

                  <div class="row">
                    <div class="card-text mt-1 ml-3"><small title="{{ $value->created_at }}" class="text-muted">预订于 {{ $value->created_at->diffForHumans() }}</small></div>
                    <div class="card-text mt-1 ml-3"><small title="{{ $value->updated_at }}" class="text-muted">
                    @if($value->user_state=='0' || $value->user_state=='1')
                      回复于 {{ $value->updated_at->diffForHumans() }}
                    @elseif($value->user_state=='3')
                      取消于 {{ $value->updated_at->diffForHumans() }}
                    @endif

                    </small></div>
                  </div>

                </div>
              </div>
            </li>
            @endforeach
            <div class="card-body">
              {!! $yes_reply_booking->appends(Request::except('page'))->render() !!}
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
<script>
  $(document).ready(function() {

    var old_tail_url=[]   // 记录之前状态 -页数
    var lastPage=Math.ceil($('#no_reply_count').val())  // 获取 待回复最后一页
    var lastPage_yesReply=Math.ceil($('#yes_reply_count').val())  // 获取 已回复最后一页
    
    if (lastPage==0) lastPage=1
    if (lastPage_yesReply==0) lastPage_yesReply=1

    var now_url_page=window.location.href.split('page=')[1]    // 获取当前页
    if(now_url_page == undefined) now_url_page=1

    //console.log('已回复页数：'+lastPage_yesReply)
    //console.log('当前页数：'+now_url_page)

    console.log(document.referrer);
    if(document.referrer.indexOf('user_booking') == -1 && document.referrer.length != 0){       // 当跳转不存在页数，referrer为空,此时也为刷新
      old_tail_url=['reply=no','reply=yes']
      console.log('跳转')
      $.removeCookie('no_reply_old_url')
      $.removeCookie('yes_reply_old_url')

    }else if(document.referrer.indexOf('user_booking') ){       
      console.log('刷新')
      if(!$.cookie('no_reply_old_url')){
        no_reply='reply=no'
       
      }else{
        if(window.location.href.indexOf('reply=no') != -1){   // 当前页面是待回复页面，则需要判断以下-page问题
          // 判断 待回复页数是否为0，且url为待回复
          if(now_url_page > lastPage){  //      最后一页问题-如果取消预定一个商品刚好没有下一页，而用户点了下一页，则改页数据为空，需返回第1页
            $.removeCookie('no_reply_old_url')
            no_reply='reply=no'
           
          }else if(now_url_page <= lastPage){
            
            no_reply=$.cookie('no_reply_old_url')
            console.log(no_reply)
          }
        }else{        // 不是则不考虑
          no_reply=$.cookie('no_reply_old_url')
        }
      }

      if(!$.cookie('yes_reply_old_url')){
        yes_reply='reply=yes'
      }else{
        if(window.location.href.indexOf('reply=yes') != -1){   // 当前页面是已回复页面，则需要判断以下-page问题
          // 判断 已回复页数是否为0，且url为待回复
          if(now_url_page > lastPage_yesReply){  //      最后一页问题-如果取消预定一个商品刚好没有下一页，而用户点了下一页，则改页数据为空，需返回第1页
            $.removeCookie('yes_reply_old_url')
            yes_reply='reply=yes'
            
          }else if(now_url_page <= lastPage_yesReply){
            
            yes_reply=$.cookie('yes_reply_old_url')
          }
        }else{        // 不是则不考虑
          yes_reply=$.cookie('yes_reply_old_url')
        }
      }
      
      //console.log(no_reply)
      old_tail_url=[no_reply,yes_reply]
      // console.log(old_tail_url)
    }

     //console.log(old_tail_url)

    // 待回复 -点击
    $('.no_reply').click(function(){
      now_url=window.location.href

      index=now_url.indexOf("reply")
      head=now_url.substring(0,index)

      //console.log(head+old_tail_url[0])
      window.location.href=head+old_tail_url[0]
    })

    // 已回复
    $('.yes_reply').click(function(){
      now_url=window.location.href

      index=now_url.indexOf("reply")
      head=now_url.substring(0,index)
      //console.log(head+old_tail_url[1])
      window.location.href=head+old_tail_url[1]
     
    })

    // 页数跳转-点击
    $('a.page-link').click(function(){
      next_url=$(this).attr('href')
      index=next_url.indexOf("reply")
      tail=next_url.substring(index)
      //var reply_expire= new Date();
      //reply_expire.setTime(expiresDate.getTime() + (60*1000));   // 2小时

      if(window.location.href.indexOf("reply=no") != -1){   // 当前为-待回复页
        $.cookie('no_reply_old_url', tail);
      }else if((window.location.href.indexOf("reply=yes") != -1)){
        $.cookie('yes_reply_old_url', tail)
      }
    })

    
    
  })

</script>

@stop