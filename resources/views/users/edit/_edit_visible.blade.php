@extends('users.edit._edit')

@section('edit_info')

<div class="card ml-4 mb-4" style="width: 875px;">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <div class="row mt-2">
        <i class="fas fa-eye ml-3 mr-2" style="font-size: 20px;"></i>
        <h4 style="line-height: 20px;">显示设置</h4>
      </div>
    </li>
  </ul>

  <div class="card-body">
    <form action="" method="" autocomplete="off">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="mb-2" style="color:#969696;font-weight:bold">个人信息</div>
      <label class="switch vis_switch2 user_switch">
        <input value="true" type="checkbox" {{ $user_vis }} class="@if(!$user_vis=='checked')  @endif">
        <div class="slider round"></div>
      </label>

      <label class="switch vis_switch user_switch" style="display: none;">
        <input type="checkbox" {{ $user_vis }} class="@if(!$user_vis=='checked') collapsed @endif" data-toggle="collapse" data-target="#collapseExample" aria-expanded="@if(!$user_vis=='checked') false @endif" aria-controls="collapseExample">
        <div class="slider round"></div>
      </label>

      <div class="collapse  @if($user_vis=='checked') show @endif user_collapse" id="collapseExample">
        <div class="card card-body">
          <input type="checkbox" class="is_vis" value="{{ $user_vis }}" hidden>
          <div class="row vis_input">
            <input type="checkbox" @if($user_visible->v_email) checked @endif name="" id="v_email" class="ml-3 mr-1">
            <label for="v_email" style="margin-top:6px;user-select:none; ">邮箱</label>
            <input type="checkbox" @if($user_visible->v_phone) checked @endif name="" id="v_phone" class="ml-4 mr-1">
            <label for="v_phone" style="margin-top:6px;user-select:none;">手机号码</label>
            <input type="checkbox" @if($user_visible->v_university) checked @endif name="" id="v_university" class="ml-4 mr-1">
            <label for="v_university" style="margin-top:6px;user-select:none;">学校</label>
            <input type="checkbox" @if($user_visible->v_faculty) checked @endif name="" id="v_faculty" class="ml-4 mr-1">
            <label for="v_faculty" style="margin-top:6px;user-select:none;">院系</label>
            <input type="checkbox" @if($user_visible->v_number) checked @endif name="" id="v_number" class="ml-4 mr-1">
            <label for="v_number" style="margin-top:6px;user-select:none;">学号</label>
            <input type="checkbox" @if($user_visible->v_r_name) checked @endif name="" id="v_r_name" class="ml-4 mr-1">
            <label for="v_r_name" style="margin-top:6px;user-select:none;">真实姓名</label>
          </div>
        </div>
      </div>



      <!-- 订购商品 -->
      <div class="mb-2 mt-4" style="color:#969696;font-weight:bold">订购商品</div>
      
      <label class="switch vis_switch_buy_goods ">
        <input value="true" type="checkbox" {{ $buy_goods_vis }}>
        <div class="slider round"></div>
      </label>
      <div class="buy_goods_collapse  @if($buy_goods_vis=='checked') show @endif " @if(!$buy_goods_vis) style="display: none;" @endif>
        <div class="card card-body">
          <input type="checkbox" class="is_vis_buy_goods" value="{{ $buy_goods_vis }}" hidden>
          <div class="row vis_input_buy_goods">
            <input type="checkbox" @if($user_visible->v_buy_booking_goods) checked @endif name="" id="v_buy_booking_goods" class="ml-3 mr-1">
            <label for="v_buy_booking_goods" style="margin-top:6px;user-select:none; ">预定</label>

            <input type="checkbox" @if($user_visible->v_buy_sale_goods) checked @endif name="" id="v_buy_sale_goods" class="ml-4 mr-1">
            <label for="v_buy_sale_goods" style="margin-top:6px;user-select:none;">已购</label>

          </div>
        </div>
      </div>

      <!-- 发布商品 -->
      <div class="mb-2 mt-4" style="color:#969696;font-weight:bold">发布商品</div>

      <label class="switch vis_switch_create_goods ">
        <input value="true" type="checkbox" {{ $create_goods_vis }}>
        <div class="slider round"></div>
      </label>
      <div class="create_goods_collapse  @if($create_goods_vis=='checked') show @endif " @if(!$create_goods_vis) style="display: none;" @endif>
        <div class="card card-body">
          <input type="checkbox" class="is_vis_create_goods" value="{{ $create_goods_vis }}" hidden>
          <div class="row vis_input_create_goods">
            <input type="checkbox" @if($user_visible->v_sale_goods) checked @endif name="" id="v_sale_goods" class="ml-3 mr-1">
            <label for="v_sale_goods" style="margin-top:6px;user-select:none; ">出售中</label>

            <input type="checkbox" @if($user_visible->v_booking_goods) checked @endif name="" id="v_booking_goods" class="ml-4 mr-1">
            <label for="v_booking_goods" style="margin-top:6px;user-select:none;">预订中</label>

            <input type="checkbox" @if($user_visible->v_saled_goods) checked @endif name="" id="v_saled_goods" class="ml-4 mr-1">
            <label for="v_saled_goods" style="margin-top:6px;user-select:none;">已出售</label>

          </div>
        </div>
      </div>


      <!--个人评论 -->
      <div class="mb-2 mt-4" style="color:#969696;font-weight:bold">个人评论</div>

      <label class="switch vis_switch_comment ">
        <input value="true" type="checkbox" {{ $comment_vis }} id="v_comment">
        <div class="slider round"></div>
      </label>

      <!-- <div class="comment_collapse  @if($comment_vis=='checked') show @endif ">
        <div class="card card-body">
          <input type="checkbox" class="is_vis_comment" value="{{ $comment_vis }}" hidden>
          <div class="row vis_input_comment">
            <input type="checkbox" @if($user_visible->v_sale_goods) checked @endif name="" id="v_sale_goods" class="ml-3 mr-1">
            <label for="v_sale_goods" style="margin-top:6px;user-select:none; "></label>
          </div>
        </div>
      </div> -->




      <div class="form-group form-check mb-2 mt-5" style=" width:98px;right:20px">
        <button type="button" class="btn btn_visible" style="margin-right:10px;width:98px;color: white;background-color: #f4645f;border-color: #f4645f;font-weight:bold">
          确认修改
        </button>
      </div>

    </form>
  </div>

</div>
@stop

@section('scriptsAfterJs')
<script>
  $(document).ready(function() {

    var u_id // 记录用户可见表的id
    var v_data // 记录获取的可见设置-数据
    is_checked() // 根据可见表，判断是否可见，添加文本颜色

    function is_checked() {
      axios.get('/ajax_visible').then(function(res) {
        v_data = res.data
        jQuery.each(res.data, function(key, value) {
          //console.log(key)
          if (key == 'id') {
            u_id = value // 赋值用户可见表的id值
            //console.log(u_id)
          }
          if (value == true) {
            //console.log('.vis_input #'+key)
            $('.vis_input #' + key).prop('checked', true)
            $('.vis_input #' + key).next().css("color", "#155724")

            $('.vis_input_buy_goods #' + key).prop('checked', true) //  购买商品
            $('.vis_input_buy_goods #' + key).next().css("color", "#155724")

            $('.vis_input_create_goods #' + key).prop('checked', true) //  发布商品
            $('.vis_input_create_goods #' + key).next().css("color", "#155724")

            // $('.vis_input_comment #' + key).prop('checked', true)  // 个人评论
            // $('.vis_input_comment #' + key).next().css("color", "#155724")

            // 
          } else {
            $('.vis_input #' + key).prop('checked', false)
            $('.vis_input_buy_goods #' + key).prop('checked', false)
            //$('.vis_input_comment #' + key).prop('checked', false)

          }
        })

      })
    }



    function slider_click(vis_switch_class, vis_switch2_class, collapse_class, vis_input_class, is_vis_class) {

      // 解决用户快速点击开关导致样式出错的问题：
      // 用一个假的开关代替真的开关(真的开关hide)。设假的开关初始value值为true，触发一次点击，设为moving表示正在移动，再设置延迟触发真正的开关点击
      // 这时候动画效果时间为0.5s(如开->关)，再嵌套延迟0.5s，设为false。
      // 如果用户在0.5s内点击了第二次，也就是在开关移动时点击了，则返回false，不执行任何事件

      // if ($('.vis_switch2 input').val() == 'moving') {
      //   return false
      // } // 判断组件是否在移动
      // //console.log($('.vis_switch2 input').val())
      // $('.vis_switch2 input').val('moving')
      // //console.log($('.vis_switch2 input').val())
      // setTimeout(() => {
      //   $('.vis_switch input').trigger('click')
      //   $('.vis_switch2 input').val('moving')
      //   setTimeout(() => {
      //     $('.vis_switch2 input').val('false')
      //   }, 500);
      // }, 100);

      // if ($('.collapse').hasClass('show')) { // 关
      //   $('.vis_input').children('input').prop('checked', false); // 移除全部选中

      // } else { // 开
      //   // console.log('用户可见都是false')
      //   if ($('.is_vis').val() == "") { // 表示可见表都是false
      //     $('.vis_input').children('input').prop('checked', true); // 设置全部选中
      //   } else {
      //     jQuery.each(v_data, function(key, value) { // 否则再根据数据设置选中
      //       if (value == true) {
      //         //console.log('.vis_input #'+key)
      //         $('.vis_input #' + key).prop('checked', true)
      //         $('.vis_input #' + key).next().css("color", "#155724")

      //       } else {
      //         $('.vis_input #' + key).prop('checked', false)
      //       }
      //     })
      //   }
      //   //$('.vis_switch input').attr("disabled",false)
      //}
    }


    // 个人信息-滑块
    $('.vis_switch2 input').click(function() {
      if ($('.user_collapse').hasClass('collapsing')) {
        return false
      } else {
        

        if ($('.user_collapse').hasClass('show')) { // 关
          $('.vis_input').children('input').prop('checked', false); // 移除全部选中

        } else { // 开
          // console.log('用户可见都是false')
          if ($('.is_vis').val() == "") { // 表示可见表都是false
            $('.vis_input').children('input').prop('checked', true); // 设置全部选中
          } else {
            jQuery.each(v_data, function(key, value) { // 否则再根据数据设置选中
              if (value == true) {
                //console.log('.vis_input #'+key)
                $('.vis_input #' + key).prop('checked', true)
                $('.vis_input #' + key).next().css("color", "#155724")

              } else {
                $('.vis_input #' + key).prop('checked', false)
              }
            })
          }
        }
        $('.vis_switch input').trigger('click')

      }
    })

    // 购买商品-滑块
    $('.vis_switch_buy_goods input').click(function() {

      $('.buy_goods_collapse').slideToggle()
      $('.buy_goods_collapse').toggleClass('show')

      if (!$('.buy_goods_collapse').hasClass('show')) { // 关

        $('.vis_input_buy_goods').children('input').prop('checked', false); // 移除全部选中

      } else { // 开
        // console.log('用户可见都是false')
        if ($('.is_vis_buy_goods').val() == "") { // 表示可见表都是false
          $('.vis_input_buy_goods').children('input').prop('checked', true); // 设置全部选中
        } else {
          jQuery.each(v_data, function(key, value) { // 否则再根据数据设置选中
            if (value == true) {
              //console.log('.vis_input #'+key)
              $('.vis_input_buy_goods #' + key).prop('checked', true)
              $('.vis_input_buy_goods #' + key).next().css("color", "#155724")

            } else {
              $('.vis_input_buy_goods #' + key).prop('checked', false)
            }
          })
        }
      }
    })

    // 发布商品-滑块
    $('.vis_switch_create_goods input').click(function() {

      $('.create_goods_collapse').slideToggle()
      $('.create_goods_collapse').toggleClass('show')

      if (!$('.create_goods_collapse').hasClass('show')) { // 关

        $('.vis_input_create_goods').children('input').prop('checked', false); // 移除全部选中

      } else { // 开
        // console.log('用户可见都是false')
        if ($('.is_vis_create_goods').val() == "") { // 表示可见表都是false
          $('.vis_input_create_goods').children('input').prop('checked', true); // 设置全部选中
        } else {
          jQuery.each(v_data, function(key, value) { // 否则再根据数据设置选中
            if (value == true) {
              //console.log('.vis_input #'+key)
              $('.vis_input_create_goods #' + key).prop('checked', true)
              $('.vis_input_create_goods #' + key).next().css("color", "#155724")

            } else {
              $('.vis_input_create_goods #' + key).prop('checked', false)
            }
          })
        }
      }
    })


    //
    // function switch_off(type_input, index, type_switch, collapse_class) {

    //   var index = index;
    //   type_input.siblings("input[type='checkbox']").each(function(i, value) {
    //     if (!value.checked) {
    //       index--;
    //     }
    //   })
    //   if (index == 0) { // 表示input全部取消选中
    //     $(type_switch + ' input').trigger('click')
    //     $(type_switch + ' input').attr('checked', 'false')
    //     $(type_switch + ' input').addClass('collapsed').attr('aria-expanded', 'false');
    //     $(collapse_class).removeClass('show');
    //   }
    // }

    // 还要判断全部不选中-switch自动关闭
    $('.vis_input').children('input').click(function() { // 个人信息

      var index = 5;
      $(this).siblings("input[type='checkbox']").each(function(i, value) {
        if (!value.checked) {
          index--;
        }
      })
      if (index == 0) { // 表示input全部取消选中
        $('.user_switch input').trigger('click')
        $('.user_switch input').attr('checked', 'false')
        $('.user_switch input').addClass('collapsed').attr('aria-expanded', 'false');
        $('.collapse').removeClass('show');
      }
    })

    $('.vis_input_buy_goods').children('input').click(function() { // 购买商品
      var index = 1;
      $(this).siblings("input[type='checkbox']").each(function(i, value) {
        if (!value.checked) {
          index--;
        }
      })
      if (index == 0) { // 表示input全部取消选中
        $('.vis_switch_buy_goods input').trigger('click')
        //$('.vis_switch_buy_goods input').attr('checked', 'false')
      }
    })

    $('.vis_input_create_goods').children('input').click(function() { // 发布商品
      var index = 2;
      $(this).siblings("input[type='checkbox']").each(function(i, value) {
        if (!value.checked) {
          index--;
        }
      })
      if (index == 0) { // 表示input全部取消选中
        $('.vis_switch_create_goods input').trigger('click')
        //$('.vis_switch_buy_goods input').attr('checked', 'false')
      }
    })



    // 点击确认修改-监听按钮
    $('.btn_visible').click(function() {
      //console.log( $('.vis_input #v_email').is(":checked") )

      // 获取用户的显示数据
      var res_visible = {
        v_email: $('.vis_input #v_email').is(":checked"),
        v_phone: $('.vis_input #v_phone').is(":checked"),
        v_university: $('.vis_input #v_university').is(":checked"),
        v_faculty: $('.vis_input #v_faculty').is(":checked"),
        v_number: $('.vis_input #v_number').is(":checked"),
        v_r_name: $('.vis_input #v_r_name').is(":checked"),

        // 购买商品
        v_buy_booking_goods: $('.vis_input_buy_goods #v_buy_booking_goods').is(":checked"),
        v_buy_sale_goods: $('.vis_input_buy_goods #v_buy_sale_goods').is(":checked"),

        // 发布商品
        v_booking_goods: $('.vis_input_create_goods #v_booking_goods').is(":checked"),
        v_sale_goods: $('.vis_input_create_goods #v_sale_goods').is(":checked"),
        v_saled_goods: $('.vis_input_create_goods #v_saled_goods').is(":checked"),

        // 个人评论
        v_comment: $('#v_comment').is(":checked"),
      }

      // 修改可见表数据
      axios.post('/ajax_visible_data/' + u_id, res_visible).then(function(res) {
        swal({
          title: '修改成功',
          icon: 'success'
        }).then(function() {
          location.reload();
        });

      }, function(error) {
        if (error.response.status === 429) { // 429 频率限制
          swal({
            title: '您提交频率过高，休息1分钟再试试吧！',
            icon: 'error'
          }).then(function() {

          });
        }
      })
      //console.log(res_visible);
    })

  })
</script>
@stop