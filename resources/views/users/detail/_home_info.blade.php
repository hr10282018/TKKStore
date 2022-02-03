<!-- 个人主页的默认路由-基本信息 -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;">
  <div class="card " style="height: 51px;">
    <div class="card-body" style="line-height:22px">
      <h1 class="mb-0" style="font-size:20px;line-height:12px">
        {{ $user->name }}
        <img src="/images/iconfont/boy.png" title="男" class="mr-2" alt="" style="width: 23px;height:23px;margin-left:3px">
        <small title="1tian" style="color:#6e7379;" class="ml-2">
          最后活跃于：1天前
        </small>
      </h1>
    </div>
  </div>

  <div class=" card mt-3">
    <div class="card-body" style="height: 55px;">
      <div class="btn btn-success ml-1   btn_all_show">
          全部显示
      </div>
      <div class="btn btn-secondary ml-1  btn_all_hide">
        全部隐藏
      </div>
    </div>
    <div class="card-body " style="overflow:auto; height:490px">

      <div class="accordion mr-1" id="accordionExample">
        <div class="card">
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <img src="/images/iconfont/email.png" class="mr-2" alt="" style="width: 25px;height:25px;margin-left:3px">邮箱
                <img src="/images/iconfont/arrow.png" class="arrow_box" style="width: 20px;height:20px; float:right;" alt="">
              </button>
            </h2>
          </div>
          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="">
            <div class="card-body">
              <span style="color:#6e7379;">{{ isset($user->email) ? $user->email : '没有数据 ^_^'  }}</span>
              @if (Auth::user()->can('update_user_info', $user))
              <img src="/images/iconfont/private.png" title="@if($user_visible->v_email) 所有人可见 @else 仅你自己可见 @endif" alt="" style="width:25px;height:25px;float:right;">
              @endif
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <img src="/images/iconfont/phone.png" class="mr-1" alt="" style="width: 28px;height:28px">手机号码
                <img src="/images/iconfont/arrow.png" class="arrow_box" style="width: 20px;height:20px; float:right;" alt="">
              </button>
            </h2>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="">
            <div class="card-body">
              <span style="color:#6e7379;">{{ isset($user->phone ) ? $user->phone  : '没有数据 ^_^'  }}</span>
              @if (Auth::user()->can('update_user_info', $user))
              <img src="/images/iconfont/private.png" title="@if($user_visible->v_phone) 所有人可见 @else 仅你自己可见 @endif" alt="" style="width:25px;height:25px;float:right;">
              @endif
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="headingThree">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <img src="/images/iconfont/university.png" class="mr-2" alt="" style="width: 28px;height:28px">学校
                <img src="/images/iconfont/arrow.png" class="arrow_box" style="width: 20px;height:20px; float:right;" alt="">
              </button>
            </h2>
          </div>
          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="">
            <div class="card-body">
              <span style="color:#6e7379;">{{ isset($user->university ) ? $user->university  : '没有数据 ^_^'  }}</span>
              @if (Auth::user()->can('update_user_info', $user))
              <img src="/images/iconfont/private.png" title="@if($user_visible->v_university) 所有人可见 @else 仅你自己可见 @endif" alt="" style="width:25px;height:25px;float:right;">
              @endif
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="headingFour">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <img src="/images/iconfont/faculty.png" class="mr-2" alt="" style="width: 24px;height:24px;margin-left:2px">院系
                <img src="/images/iconfont/arrow.png" class="arrow_box" style="width: 20px;height:20px; float:right;" alt="">
              </button>
            </h2>
          </div>
          <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="">
            <div class="card-body">
              <span style="color:#6e7379;">{{ isset($user->faculty ) ? $user->faculty  : '没有数据 ^_^'  }}</span>
              @if (Auth::user()->can('update_user_info', $user))
                <img src="/images/iconfont/private.png" title="@if($user_visible->v_faculty) 所有人可见 @else 仅你自己可见 @endif" alt="" style="width:25px;height:25px;float:right;">
              @endif
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="headingFive">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                <img src="/images/iconfont/stuID.png" class="mr-2" alt="" style="width: 24px;height:24px;margin-left:2px">学号
                <img src="/images/iconfont/arrow.png" class="arrow_box" style="width: 20px;height:20px; float:right;" alt="">
              </button>
            </h2>
          </div>
          <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="">
            <div class="card-body">
              <span style="color:#6e7379;">{{ isset($user->number ) ? $user->number  : '没有数据 ^_^'  }} </span>
              @if (Auth::user()->can('update_user_info', $user))
                <img src="/images/iconfont/private.png" title="@if($user_visible->v_number) 所有人可见 @else 仅你自己可见 @endif" alt="" style="width:25px;height:25px;float:right;">
              @endif
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="headingSix">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                <img src="/images/iconfont/r_name.png" class="mr-2" alt="" style="width: 25px;height:25px;margin-left:1px">姓名
                <img src="/images/iconfont/arrow.png" class="arrow_box" style="width: 20px;height:20px; float:right;" alt="">
              </button>
            </h2>
          </div>
          <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="">
            <div class="card-body">
              <span style="color:#6e7379;">{{ isset($user->r_name ) ? $user->r_name  : '没有数据 ^_^'  }}</span>
              @if (Auth::user()->can('update_user_info', $user))
              <img src="/images/iconfont/private.png" title="@if($user_visible->v_r_name) 所有人可见 @else 仅你自己可见 @endif" alt="" style="width:25px;height:25px;float:right;">
              @endif
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

</div>
@stop

@section('scriptsAfterJs')
<script>
  $(document).ready(function() {

    // 折叠样式-全部展开
    $('.btn_all_show').click(function() {
      //console.log($('.accordion button'))
      //console.log($('.collapse'));
      $('.accordion button').attr('aria-expanded', 'true').removeClass('collapsed').children('.arrow_box').css({
        "transform":"rotate(180deg)",
          "-webkit-transform": "rotate(180deg)",
          "-moz-transform":"rotate(180deg)",
          "-o-transform":"rotate(180deg)",
      })
      $('.collapse').addClass('show')
    })
    // 折叠样式-全部隐藏
    $('.btn_all_hide').click(function() {
      //console.log('hide')
      $('.accordion button').attr('aria-expanded', 'false').addClass('collapsed').children('.arrow_box').css({
        "transform":"rotate(0deg)",
          "-webkit-transform": "rotate(0deg)",
          "-moz-transform":"rotate(0deg)",
          "-o-transform":"rotate(0deg)",
      })
      $('.collapse').removeClass('show')
    })

    // 点击-箭头样式
    $('.accordion button').click(function(){
      if(!$(this).hasClass('collapsed')){       // 隐藏
        $(this).children('.arrow_box').css({
          "transform":"rotate(0deg)",
          "-webkit-transform": "rotate(0deg)",
          "-moz-transform":"rotate(0deg)",
          "-o-transform":"rotate(0deg)",
        })
      }else{
        $(this).children('.arrow_box').css({      // 展开
          "transform":"rotate(180deg)",
          "-webkit-transform": "rotate(180deg)",
          "-moz-transform":"rotate(180deg)",
          "-o-transform":"rotate(180deg)",
        })
      }
    })

  })
</script>
@stop
