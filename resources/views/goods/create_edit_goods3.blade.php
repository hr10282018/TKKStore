@extends('layouts.app')
@section('title', '首页')

@section('content')

<div class="card ml-4 " style="width: 875px;left:250px;  margin-bottom:100px;">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <div class="row mt-2">
        <i class="far fa-edit ml-3 mr-2" style="font-size: 20px;font-weight:bold;"></i>
        @if(isset($goods_info->id))
        <h4 style="line-height: 20px;font-weight:550">编辑商品</h4>
        @else
        <h4 style="line-height: 20px;font-weight:550">发布商品</h4>
        @endif

      </div>

    </li>

  </ul>

  <div class="card-body">
    <form class="form_create_goods" action="{{ route('create_goods_check') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">

      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group " style="width:810px;">
        <label for="title" style="font-size:16px">标题</label>
        <div class="row ml-0">
          <input type="" autocomplete="on" maxlength="255" name="title" class="form-control" id="title" placeholder="显示在商品列表页..." style="width:750px" value="@if(isset($goods_info)){{ $goods_info->title }}@endif" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2"></div>
        </div>
      </div>

      <div class="form-group" style="width:750px;">
        <label for="description" style="font-size:16px">描述</label>
        <textarea class="form-control" id="description" rows="2" placeholder="显示在商品详情页..." name="description" style="height:52px;max-height: 126px;min-height: 52px;" required>@if(isset($goods_info)){{ $goods_info->description }}@endif</textarea>
      </div>

      <div class="form-group" style="width:750px;">
        <label for="description" style="font-size:15px">卖家标签</label>

        <div>

          @foreach($good_tag as $tags=>$tag)
          <button type="button" class="btn btn_tag @if(isset($goods_info->id) && $tags <= count($tags_data->toArray())-1 ) @if(in_array($tag->name,$tags_data->toArray()[$tags])) active @endif @elseif($tags == 0) active   @endif" style="outline:none;line-height:15px;height:27px;border: 1px solid #e8eaec; background: #f7f7f7;font-size: 12px;color: #515a6e">
            {{ $tag->name }}
          </button>
          @endforeach

        </div>

        <input class="tags_data" type="text" name="tag_data" hidden>
      </div>

      <div class="form-group">
        <label for="price" style="font-size:16px">标价</label>
        <div class="row ml-0">
          <input type="" autocomplete="on" name="price" maxlength="6" minlength="1" class="form-control" id="price" placeholder="请填写数字价格，最多保留一位小数..." style="width:405px;" value="@if(isset($goods_info)){{ $goods_info->price }}@endif" required>
          <span style="line-height:35px ;color:#636b6f;" class="ml-2">填写范围为 0.1 ~ 9999.9</span>
          <div class="wrong_tip_price"></div>
        </div>
      </div>

      <div class="form-group">
        <label for="old_price" style="font-size:15px">原价</label>
        <input type="text" autocomplete="off" name="old_price" maxlength="6" class="form-control " id="old_price" placeholder="" style="width:405px;" value="@if(isset($goods_info)){{ $goods_info->old_price }}@endif" required>
        <div class="wrong_tip_oprice "></div>
      </div>

      <div class="form-group">
        <label for="u_phone" style="font-size:16px">分类</label>
        <select class="form-control" name="category_id" id="category" style="width:405px;">
          <option @if(isset($goods_info) && $goods_info->category_id == 1 ) selected @endif>学习</option>
          <option @if(isset($goods_info) && $goods_info->category_id == 2 ) selected @endif>生活</option>
          <option @if(isset($goods_info) && $goods_info->category_id == 3 ) selected @endif>娱乐</option>
          <option @if(isset($goods_info) && $goods_info->category_id == 4 ) selected @endif>其他</option>
        </select>
      </div>

      <div class="form-group mt-4">
        <p style="font-size:17px;">商品图片：<small style="color: #969696;">第一张默认为封面图片</small>
          <button type="button" id="add" class="btn btn-success ml-2" style="line-height:20px;width:90px;height:32px;">
            继续添加
          </button>
        </p>
      </div>

      <div class="img_file">
        <div class="form-group " style="border:1px #dee2e6 solid;height:48px;width: 800px;border-radius:5px;">
          <input type="file" id="first_file" autocomplete="on" value="xxx" name="goods_img[]" data-toggle="tooltip" data-placement="bottom" class="form-control-file file ml-2 " title="请上传 (PNG,JPG,GIF,JPEG) 格式的图片" style="margin-top: 12px;" required />
          {{-- <div class="wrong_tip_img  ml-1 mt-3 mb-1"></div> --}}
        </div>
        <div class="ml-2 wrong_tip_type" hidden style="color: #e3342f;font-size: 80%;">
          <strong>不支持该图片格式，请重新选择！!</strong>
        </div>
        <div class="ml-2 wrong_tip_size" hidden style="color: #e3342f;font-size: 80%;">
          <strong>图片大小超过200K，请重新选择！!</strong>
        </div>

        <!-- <div class="form-group mt-5" style="position:relative;border:1px #dee2e6 solid;height:48px;width:800px; border-radius:5px;">
          <input type="file" autocomplete="off" name="goods_img[]" data-toggle="tooltip" data-placement="bottom" class="form-control-file file ml-2 is-invalid" title="请上传 (PNG,JPG,GIF,JPEG) 格式的图片" style="margin-top: 12px;" required />
          <div class="input-group-append mb-4" style="height:44.5px;float:right;position:relative;top:-36.5px">
            <button class="btn btn-outline-danger ml-1 file_` + index + `" type="button" id="button-addon2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                <path style="line-height:30px" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
              </svg>
            </button>
          </div>
        </div>
        <div class="ml-2 wrong_tip_type" hidden style="color: #e3342f;font-size: 80%;">
          <strong>格式错误！</strong>
        </div>
        <div class="ml-2 wrong_tip_size" hidden style="color: #e3342f;font-size: 80%;">
          <strong>大小错误！</strong>
        </div> -->

      </div>

      <div class="form-group form-check mb-2 row" style="right:20px">
        <button type="submit" hidden class="btn btn-primary mt-4 ml-3 btn_submit" style="line-height:20px;margin-right:10px;width:90px;height:32px">
        </button>
        <button type="button" class="btn btn-primary mt-5 ml-3 btn_now" style="line-height:20px;margin-right:10px;width:90px;height:32px">
          立即发布
        </button>

        <button type="button" title="保存" class="btn btn-secondary mt-5 ml-3 btn_wait" style="line-height:20px;margin-right:10px;width:90px;height:32px">
          暂不发布
        </button>
        <input class="state" name="goods_state" type="text" hidden>

      </div>

    </form>
  </div>

</div>


@stop

@section('scriptsAfterJs')
<script>
  $(document).ready(function() {

    // 循环遍历-为active 添加样式
    $(".btn_tag").each(function(index) {
      
      //console.log($(".btn_tag")[index]);
      if ($(".btn_tag").eq(index).hasClass('active')) {
        $(this).css({
          'background': '#2d8cf0',
          'color': '#fff'
        })
      }
    })


    // 标签按钮-点击事件
    var max_tag = true // 记录标签能否选择
    $('.btn_tag').click(function() {
      if (max_tag) {
        $(this).toggleClass('active')
        if ($(this).hasClass('active')) {
          $(this).css({
            'background': '#2d8cf0',
            'color': '#fff'
          })
        } else {
          $(this).css({
            'background': '#f7f7f7',
            'color': '#515a6e'
          })
        }
      } else {
        //console.log('')
        if ($(this).hasClass('active')) {
          $(this).toggleClass('active')
          $(this).css({
            'background': '#f7f7f7',
            'color': '#515a6e'
          })
        } else {
          swal("最多选择四个标签", {
            buttons: false,
            icon: 'warning',
            timer: 2500
          });
        }
      }
      // 最多选择四个标签
      if ($('.btn_tag.active').length == 4) {
        max_tag = false
      } else {
        max_tag = true
      }
    })

    function reg_price() {
      var price = $("#price").val();
      var d_reg = /^\d{1,4}\.{1}[1-9]{1}$/; // 小数-首位可以0，小数位不为0
      var d_reg2 = /^[1-9]{1,4}\.{1}\d{1}$/; //  小数-首位不能0，小数位可为0
      var int_reg = /^[1-9]{1}\d{0,5}$/; // 整数-首位不能0
      if ($('#price').val().length != 0) {
        if (d_reg.test(price) || d_reg2.test(price) || int_reg.test(price)) { // 原价格式正确
          $("#price").addClass('is-valid').removeClass('is-invalid');
          $(".wrong_tip_price").addClass('valid-feedback').removeClass('invalid-feedback');
          $(".wrong_tip_price").html('');
        } else {
          $("#price").addClass('is-invalid').removeClass('is-valid');
          $(".wrong_tip_price").addClass('invalid-feedback').removeClass('valid-feedback');
          $(".wrong_tip_price").html('<strong>格式错误，请重新填写！!</strong>');
        }
      } else {
        $("#price").removeClass('is-valid').removeClass('is-invalid');
        $(".wrong_tip_price").removeClass('valid-feedback').removeClass('invalid-feedback');
        $(".wrong_tip_price").html('');
      }
    }
    // 验证标价字段
    reg_price()
    $('#price').blur(function() {
      reg_price()
    })

    function reg_old_price() {
      var price = $("#old_price").val();
      var d_reg = /^\d{1,4}\.{1}[1-9]{1}$/; // 小数-首位可以0，小数位不为0
      var d_reg2 = /^[1-9]{1,4}\.{1}\d{1}$/; //  小数-首位不能0，小数位可为0
      var int_reg = /^[1-9]{1}\d{0,5}$/; // 整数-首位不能0
      if ($('#old_price').val().length != 0) {
        if (d_reg.test(price) || d_reg2.test(price) || int_reg.test(price)) { // 原价格式正确
          $("#old_price").addClass('is-valid').removeClass('is-invalid');
          $(".wrong_tip_oprice").addClass('valid-feedback').removeClass('invalid-feedback');
          $(".wrong_tip_oprice").html('');
        } else {
          $("#old_price").addClass('is-invalid').removeClass('is-valid');
          $(".wrong_tip_oprice").addClass('invalid-feedback').removeClass('valid-feedback');
          $(".wrong_tip_oprice").html('<strong>格式错误，请重新填写！!</strong>');
        }
      } else {
        $("#old_price").removeClass('is-valid').removeClass('is-invalid');
        $(".wrong_tip_oprice").removeClass('valid-feedback').removeClass('invalid-feedback');
        $(".wrong_tip_oprice").html('');
      }
    }
    // 验证原价字段
    reg_old_price()
    $('#old_price').blur(function() {
      reg_old_price()
    })

    // 添加商品图片-点击事件
    var add = document.getElementById('add');
    var index = 0;
    var top = -37;
    $("#add").click(function() {
      //console.log($("input[type='file']").length)
      if ($("input[type='file']").length >= 4) {
        // console.log('最多选择四个图片！')
        swal("最多选择四个图片", {
          buttons: false,
          icon: 'warning',
          timer: 2500
        });
        return false;
      }

      index++;
      top--;
      var el = $(
        `<div class="form-group mb-3  mt-5" style="border:1px #dee2e6 solid;height:48px;width:800px; border-radius:5px;">
            <input type="file" autocomplete="off" name="goods_img[]" data-toggle="tooltip" data-placement="bottom" class="form-control-file file ml-2 " title="请上传 (PNG,JPG,GIF,JPEG) 格式的图片" style="margin-top: 12px;" required />
            <div class="input-group-append mb-4" style="height:48px;float:right;position:relative;top:` + top + `px;left:1px">
              <button class="btn btn-danger ml-1 file_` + index + `" type="button" id="button-addon2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                  <path style="line-height:30px" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                </svg>
              </button>
            </div>
          </div>
          <div class="ml-2 wrong_tip_type" hidden style="color: #e3342f;font-size: 80%;">
            <strong>不支持该图片格式，请重新选择！!</strong>
          </div>
          <div class="ml-2 wrong_tip_size" hidden style="color: #e3342f;font-size: 80%;">
            <strong>图片大小超过200K，请重新选择！!</strong>
          </div>`);
      el.appendTo($('.img_file'));

    });

    $(".img_file ").on("click", "button", function() {

      $(this).parent().parent().next().remove()
      $(this).parent().parent().next().remove()
      $(this).parent().parent().remove();
    })


    // 验证上传图片(类型、大小、宽)-change事件
    $(".img_file").on("change", "input", function() {

      file = $(this)[0].files[0]
      img_ext = file.type // 获取图片类型
      //console.log(img_ext)
      var png = new RegExp('png');
      var jpg = new RegExp('jpg');
      var jpeg = new RegExp('jpeg');
      var gif = new RegExp('gif');
      img_size = Math.floor(file.size / 1024)
      //console.log(img_size)
      if (png.test(img_ext) || jpg.test(img_ext) || jpeg.test(img_ext) || gif.test(img_ext)) {

        if (img_size > 200) {
          $(this).parent('div').css('border', '1px solid #e3342f')
          // if ($('#first_file').index('input') == $(this).index('input')) {

          //   $(this).addClass('is-invalid').removeClass('is-valid');
          //   $(this).next().addClass('invalid-feedback').removeClass('valid-feedback');
          //   $(this).next().html('<div class=""><strong>图片大小超过K，请重新选择！!</strong></div>');
          // } else {
          $(this).parent().next().next().removeAttr('hidden')
          //}
        } else { // 图片格式、大小都符合
          $(this).parent('div').css('border', '1px solid #dee2e6')
          // if ($('#first_file').index('input') == $(this).index('input')) {
          //   $(this).addClass('is-valid').removeClass('is-invalid');
          //   $(this).next().addClass('valid-feedback').removeClass('invalid-feedback');
          //   $(this).next().html('');
          // } else {
          $(this).parent().next().prop("hidden", true)
          $(this).parent().next().next().prop("hidden", true)
          //}
        }
      } else { // 格式不正确
        $(this).parent('div').css('border', '1px solid #e3342f')
        // if ($('#first_file').index('input') == $(this).index('input')) {

        //   $(this).addClass('is-invalid').removeClass('is-valid');
        //   $(this).next().addClass('invalid-feedback').removeClass('valid-feedback');
        //   $(this).next().html('<strong>不支持该图片格式，请重新选择！!</strong>');
        // } else {
        $(this).parent().next().removeAttr('hidden')
        //}
        if (img_size > 200) { // 都不正确
          // if ($('#first_file').index('input') == $(this).index('input')) {
          //   $(this).next().append('<div class=""><strong>图片大小超过200K，请重新选择！!</strong></div>');
          // } else {

          $(this).parent().next().removeAttr('hidden')
          $(this).parent().next().next().removeAttr('hidden')
          //}
        }
      }
      // 验证图片宽高
      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function(e) {
        var data = e.target.result;
        //加载图片获取图片真实宽度和高度
        var image = new Image();
        image.src = data;
        // 图片先加载完，才可以得到图片宽度和高度
        image.onload = function() {
          var width = image.width;
          var height = image.height;
          // 验证图片宽高 最小宽和高278和318-最大宽和高480和518
          // 宽超过480，则设计一个tip，提示自动裁剪
          //console.log('宽：', width)
          // if (width > 480) {
          //   console.log('自动裁剪')
          // }
        }
      }
    })


    // 立即发布按钮-点击事件
    $('.btn_now').click(function() {
      // 设置标签数据
      //console.log($('.btn_tag'))
      var tag_data = ''
      $.each($('.btn_tag'), function(i, val) {
        if ($(this).hasClass('active')) {
          if (tag_data == '') {
            tag_data = (i + 1)

          } else {
            tag_data = tag_data + '-' + (i + 1)
          }
        }
      })
      $('.tags_data').val(tag_data)
      //console.log($('.tags_data').val())

      // 设置状态-发布
      $('.state').val(1)

      var file
      for (var i = 0; i < $('.file').length; i++) { // 判断所有图片是否为空
        if ($(".file").eq(i).val().length == 0) {
          file = 0
          break
        }
      }
      if (file == 0 || $('#description').val().length == 0 || $('#title').val().length == 0 || $('#price').val().length == 0 || $('#old_price').val().length == 0) {
        $('.btn_submit').trigger('click')
      } else {
        if ($('.is-invalid').length != 0) {
          swal({
            text: '有错误选项，无法提交！',
            icon: 'error'
          })
        } else {

          if ($('#old_price').val().length != 0 && $('#price').val().length != 0) {

            var price = parseFloat($('#price').val());
            var old_price = parseFloat($('#old_price').val())
            if (price > old_price) {
              // console.log('标价大于原价！')
              swal({
                title: '你确定吗?',
                text: "该商品的标价高于原价 ！",
                icon: 'warning',
                buttons: ['取消', '确认无误'],
                dangerMode: true,
              }).then((res) => {
                if (!res) return;
                $('.form_create_goods').submit()
              })
              $('.swal-text').addClass('warning_text'); // 控制swal-text的样式
              $('.swal-footer').css("text-align", "center") // 确认取消按钮-居中
            } else {
              swal({
                title: '确定立即发布?',
                icon: 'warning',
                buttons: ['取消', '确定'],
                dangerMode: true,
              }).then((res) => {
                if (!res) return;
                //console.log($('.file').val())
                $('.form_create_goods').submit()

              })
            }

          }

        }
      }
    })

    // 暂不发布按钮-点击事件
    $('.btn_wait').click(function() {
      // 设置标签数据
      //console.log($('.btn_tag'))
      var tag_data = ''
      $.each($('.btn_tag'), function(i, val) {
        if ($(this).hasClass('active')) {
          if (tag_data == '') {
            tag_data = (i + 1)

          } else {
            tag_data = tag_data + '-' + (i + 1)
          }
        }
      })
      $('.tags_data').val(tag_data)
      //console.log($('.tags_data').val())

      // 设置状态-未发布
      $('.state').val(0)

      var file
      for (var i = 0; i < $('.file').length; i++) { // 判断所有图片是否为空
        if ($(".file").eq(i).val().length == 0) {
          file = 0
          break
        }
      }
      if (file == 0 || $('#description').val().length == 0 || $('#title').val().length == 0 || $('#price').val().length == 0 || $('#old_price').val().length == 0) {
        $('.btn_submit').trigger('click')
      } else {
        swal({
          title: '暂不发布',
          text: '?',
          buttons: ['取消', '确定'],
        }).then((res) => {
          if (!res) return;
          $('.form_create_goods').submit()
        })

        $('.swal-text').css({
          "background-color": "#FEFAE3",
          "padding": "17px",
          "border": "1px solid #F0E1A1",
          "display": "block",
          "margin": "22px",
          "text-align": "center",
          "color": "#61534e"
        })
        $('.swal-text').html('未发布商品可在 "个人中心"&#10132"我的商品" 中进行查看')
      }

    })



  })
</script>

@stop