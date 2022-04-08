
<!-- 预订通知展示 -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;margin-bottom:75px">
  <div class="card ">
    <div class="card-body">
      <div class="row ">
      <i class="far fa-envelope mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
        <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
         {{ $user->name }}
          <span style="letter-spacing:2px"> 预订通知</span>
          @if(!Auth::user()->can('update_user_info', $user))
          （*）
          @else
          （{{ count($user->bookingsUser) }}）
          @endif
        </h1>
      </div>
    </div>

    <hr style="width: 650px;margin:0 auto;">

    <div class="card-body">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item no_reply" role="presentation">
          <a class="nav-link  @if(reply_acyive('no')) active @endif" id="home-tab" data-toggle="tab" href="#no_reply" role="tab" aria-controls="no_reply" aria-selected="@if(reply_acyive('no')) true @else false @endif">
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
          <a class="nav-link @if(reply_acyive('yes')) active @endif" id="profile-tab" data-toggle="tab" href="#yes_reply" role="tab" aria-controls="yes_reply" aria-selected="@if(reply_acyive('yes')) true @else false @endif">
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

      <input type="text"  value="{{ $no_reply_count/5 }}" name="" id="no_reply_count" hidden>   <!-- 待回复页数 -->
      <input type="text" value="{{ $yes_reply_count/5 }}" name="" id="yes_reply_count" hidden>   <!-- 已回复页数-->

      <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade @if(reply_acyive('no')) show active @endif" id="no_reply" role="tabpanel" aria-labelledby="home-tab">
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
                      <img src="{{ Str::before($value->goods->image,',') }}" style="width: 100px; height:100px;" alt="...">
                    </a>
                  </div>
                  <div class="ml-2" >

                    <div class="mt-1">
                      <a href="{{ route('user_show' , $value->buyer->id) }}" target="_blank">
                        <img src="{{ $value->buyer->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                      </a>
                      <a href="{{ route('user_show' , $value->buyer->id) }}">{{ $value->buyer->name }}</a>  向你发送了商品预订请求，请尽快处理！
                    </div>

                    <div class="card-text mt-1 ml-3 row" >
                      <small  title="{{ $value->created_at }}" class="text-muted mt-2">预订于 {{ $value->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="card-text mt-2">
                      <button type="button" data-id="{{ $value->id }}" class="btn btn-sm btn-outline-success ml-2 btn_agree" style="width: 58px; height:29px;">同意</button>
                      <button type="button" data-id="{{ $value->id }}" class="btn btn-sm btn-outline-danger ml-2 btn_refuse" style="width: 58px; height:29px;">拒绝</button>
                    </div>

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

        <div class="tab-pane fade @if(reply_acyive('yes')) show active @endif" id="yes_reply" role="tabpanel" aria-labelledby="profile-tab">
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
                  <a href="{{ route('goods_detail',$value->goods->id ) }}" target="_blank">
                    <img src="{{ Str::before($value->goods->image,',') }}" style="width: 100px; height:100px;" alt="...">
                  </a>
                </div>
                <div class="ml-2" >
                  <div class="mt-1">
                    
                    @if($value->user_state=='0' || $value->user_state=='1')
                      <a class="mr-1" href="{{ route('user_show' , $value->user->id) }}" target="_blank">
                        <img src="{{ $value->user->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                      </a>
                      <!-- <a href="{{ route('user_show' , $value->user->id) }}" target="_blank">{{ $value->user->name }}</a> -->
                      你
                      <span style="color:{{ ($value->user_state=='1') ? 'green':'red'  }};">{{ ($value->user_state=='1') ? '【同意】':'【拒绝】' }}</span> 预订
                      @if($value->user_state == '1')
                        ，前往 <a href="#">订单</a> ！
                      @else
                      ！
                      @endif

                    @elseif($value->user_state=='3')
                      <a href="{{ route('user_show' , $value->buyer->id) }}" target="_blank">
                        <img src="{{ $value->buyer->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                      </a>
                      <a href="{{ route('user_show' , $value->buyer->id) }}" target="_blank">{{ $value->buyer->name }}</a>
                      <span style="color:#636b6f">【取消】</span> 预定！
                    @endif
                  </div>

                  <div class="ml-2 mt-1 ">    {{-- 拒绝原因 --}}
                    @if($value->user_state=='0') 
                      <span style="font-size: 12px;color:#ff5d23">【拒绝原因】:</span> 
                      @if($value->reason!='')
                        <span style="color: #ff5d23;font-size: 11px;font-weight:bold">" {{ $value->reason }} "</span>
                      @else
                      <span style="color: #636b6f;font-size: 11px;font-weight:bold">" 无 "</span>
                      @endif
                    @endif
                  </div>

                  <div class="row">
                    <div class="card-text mt-1 ml-3"><small title="{{ $value->created_at }}" class="text-muted">预订于 {{ $value->created_at->diffForHumans() }}</small></div>

                    <div class="card-text mt-1 ml-3">
                      <small title="{{ $value->updated_at }}" class="text-muted">
                        @if($value->user_state=='0' || $value->user_state=='1')
                          回复于 {{ $value->updated_at->diffForHumans() }}
                        @elseif($value->user_state=='3')
                          取消于 {{ $value->updated_at->diffForHumans() }}
                        @endif
                      </small>
                  </div>
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

    if(document.referrer.indexOf('booking_notice') == -1 && document.referrer.length != 0){   // 当跳转不存在页数，referrer为空,此时也为刷新
      // console.log('跳转')
      old_tail_url=['reply=no','reply=yes']
    
      $.removeCookie('notice_no_reply_old_url')
      $.removeCookie('notice_yes_reply_old_url')
    }else{
      //console.log('刷新')
      
      if(!$.cookie('notice_no_reply_old_url')){
        no_reply='reply=no'
      }else{
        if(window.location.href.indexOf('reply=no') != -1 ){   // 当前页面是待回复页面，则需要判断以下-page问题
          // 判断 待回复页数是否为0，且url为待回复
          if(now_url_page > lastPage){  //      最后一页问题-如果取消预定一个商品刚好没有下一页，而用户点了下一页，则改页数据为空，需返回第1页
            $.removeCookie('notice_no_reply_old_url')
            no_reply='reply=no'
          }else if(now_url_page <= lastPage){
            no_reply=$.cookie('notice_no_reply_old_url')
          }
        }else{
          no_reply=$.cookie('notice_no_reply_old_url')
        }
        
      }
      if(!$.cookie('notice_yes_reply_old_url')){
        yes_reply='reply=yes'
      }else{
        if(window.location.href.indexOf('reply=yes') != -1){   // 当前页面是已回复页面，则需要判断以下-page问题
          // 判断 已回复页数是否为0，且url为待回复
          if(now_url_page > lastPage_yesReply){  //      最后一页问题-如果取消预定一个商品刚好没有下一页，而用户点了下一页，则改页数据为空，需返回第1页
            $.removeCookie('notice_yes_reply_old_url')
            yes_reply='reply=yes'
          }else if(now_url_page <= lastPage_yesReply){
            yes_reply=$.cookie('notice_yes_reply_old_url')
          }
        }else{
          yes_reply=$.cookie('notice_yes_reply_old_url')
        }
        
      }
    
      old_tail_url=[no_reply,yes_reply]
      //console.log(old_tail_url)
    }
    
    // 待回复 -点击
    $('.no_reply').click(function(){
      
      now_url=window.location.href

      index=now_url.indexOf("reply")
      head=now_url.substring(0,index)

      window.location.href=head+old_tail_url[0]
      //console.log(old_tail_url[0])
      //console.log(now_url.substring(index))
    })
    $('.yes_reply').click(function(){
      now_url=window.location.href

      index=now_url.indexOf("reply")
      head=now_url.substring(0,index)
      window.location.href=head+old_tail_url[1]
    })

    // 页数跳转-点击
    $('a.page-link').click(function(){
      next_url=$(this).attr('href')
      index=next_url.indexOf("reply")
      tail=next_url.substring(index)
      //var reply_expire= new Date();
      //reply_expire.setTime(expiresDate.getTime() + (60*1000));   // 2小时

      if(window.location.href.indexOf("reply=no") != -1){
        $.cookie('notice_no_reply_old_url', tail);
      }else if((window.location.href.indexOf("reply=yes") != -1)){
        $.cookie('notice_yes_reply_old_url', tail)
      }
    })


    // 同意预定
    $('.btn_agree').click(function(){
      var id = $(this).data('id');      // 预定id
      
      swal({
        title: '你确定同意吗?',
        text: " ",
        icon: 'info',
        buttons: ['取消', '确定'],
        
      }).then((res) => {
        if (!res) {
          return;
        }
        axios.post('/agree_booking/'+ id).then(function(res){
          // console.log(res.data)
          swal({
            title: '同意成功！',
            text: "你有新的订单需要确认发送！",
            icon: 'success',
            buttons: ['暂不发送', '立即发送'],
          }).then((res)=>{
            if(res){
              // 跳转订单
        
            }else{
              location.reload()
            }
          })

          $('.swal-text').addClass('warning_text')
          $('.swal-text').css('text-align','left')
           // 或者 一定时间内
          $('.swal-text').html(
          '<span style="color:#e3342f;">&lowast;操作事项</span>：你需要向买家发送订单进行核对，双方一致同意订单信息后，则完成交易！'+
          '<br><br> <span style="font-size:12px;"><span style="color:#e3342f;">&lowast;注：</span>请及时完成订单确认，将会影响你的其他操作！</span>')   

        },function(error){
          console.log(1)
        })
      })
      $('.swal-text').addClass('warning_text')
      $('.swal-text').html('确认<span style="color:#38c172;">【同意】</span>后将生成一个订单！<br>可在【个人中心】&#10132【出售订单】&#10132【待确认】 中查看!')
      
    })

    // 拒绝预定
    $('.btn_refuse').click(function(){

      var id = $(this).data('id');      // 预定id
      //console.log(id)
      

      swal({
        title: '你确定拒绝吗?',
        text: " ",
       
        // 填写拒绝理由
        content: {
          element: "input",
          attributes: {
            placeholder: "拒绝原因（0-32字）",
            type: "text",
          },
        },
        icon: 'info',
        buttons: ['取消', '确定'],
        
      }).then((res) => {
        
        if(!res) return
        
        
        refuse_reason=$('.swal-content__input').val()
        if(refuse_reason.length >32){     // 超过长度，啥也不做

        }else{
           //console.log(refuse_reason)
          axios.post('/refuse_booking/'+ id,{refuse_reason}).then(function(res){
            console.log(res.data)
            swal({
              title: '拒绝成功！',
              text: "",
              icon: 'success',
              //buttons: ,
            }).then((res)=>{
              location.reload()
            })
          })
        
      }
      
      })
      $('.swal-content__input').attr('maxlength',32)
      $('.swal-content__input').after('<div class=""></div>')
      $('.swal-content__input').blur(function(){      // 判断长度
        refuse_reason=$('.swal-content__input').val()
        if(refuse_reason.length >32 ){
          if(!$('.swal-content__input').hasClass('is-invalid')){
            $('.swal-content__input').addClass('is-invalid').addClass('form-control')
            $('.swal-content__input').next().addClass('invalid-feedback')
            $('.swal-content__input').next().html('长度介于0-32个字符')
            $('.swal-button--confirm').attr('disabled',true);
          }
        }else if(refuse_reason.length <=32 && refuse_reason.length>=0){
          console.log('ys')
          $('.swal-content__input').removeClass('is-invalid')
          $('.swal-content__input').next().removeClass('invalid-feedback')
          $('.swal-content__input').next().html('')
          $('.swal-button--confirm').attr('disabled',false);
        }
      })
      
      
      
      
    })

    


  })

</script>

@stop