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
        <textarea maxlength="512" class="form-control" id="description" rows="2" placeholder="显示在商品详情页..." name="description" style="height:52px;max-height: 126px;min-height: 52px;" required>@if(isset($goods_info)){{ $goods_info->description }}@endif</textarea>
      </div>

      <div class="form-group" style="width:750px;">
        <label for="tag" style="font-size:15px">卖家标签</label>
        <div>
          <?php  $index=0 ?>
          
          @foreach($good_tag as $tags=>$tag)
        
          <button type="button" class="btn btn_tag @if(isset($goods_info) && $index <= count($tags_data->toArray())-1) @if($tag->name == $tags_data->toArray()[$index]['name'] ) active  <?php  $index++ ?> @endif @elseif($tags == 0) active  @endif" style="outline:none;line-height:15px;height:27px;border: 1px solid #e8eaec; background: #f7f7f7;font-size: 12px;color: #515a6e">
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
        <input type="text" autocomplete="on" name="old_price" maxlength="6" class="form-control " id="old_price" placeholder="" style="width:405px;" value="@if(isset($goods_info)){{ $goods_info->old_price }}@endif" required>
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
        <p style="font-size:17px;">商品图片：<small style="color: #969696;">【第一张默认为封面图片, 建议上传图片长宽为：450x460】</small>
          <button type="button" id="add" class="btn btn-success ml-2" style="line-height:20px;width:90px;height:32px;">
            添加图片
          </button>
        </p>
      </div>
      
      {{-- @if( $booking )
        <input type="" id="booking_operate_premise" hidden>
      @elseif( $order )
        <input type="" id="order_operate_premise"  hidden>
      @endif
      <input type="" id="user_id" value="{{ Auth::user()->id }}" hidden> --}}
      
      <!-- 图片文件 -->
      @if(isset($goods_info))
       <?php  $arrImg = explode(',',$goods_info->image) ?>
      @endif
      <div class="img_file form-group">
        <div class=" input-group imgFile" style="width:91%;">
          <div class="input-group-append"></div>
          <div class=" custom-file">
            <input type="file" title="点击上传商品图片 ^_^ " class="custom-file-input file" img_data="@if(isset($goods_info)){{ $goods_info->image }}@endif" name="goods_img[]" id="validatedInputGroupCustomFile" autocomplete="off" required>
            <label class="custom-file-label " for="validatedInputGroupCustomFile">@if(isset($goods_info)) {{ 'P0.'.Str::afterLast($arrImg[0], '.') }} @else 选择图片文件... @endif</label>
          </div>
        </div>
        <div class=" file_tip_size"> </div>
        <div class=" file_tip_type"> </div>

        @if(isset($goods_info))
          @for($i=1;$i<sizeof($arrImg);$i++) 
          <div class="mt-4 input-group imgFile" style="width:91%;">
            <div class="input-group-append">
              <button class="btn  btn-danger del_btn" type="button" style="top:-1px;border-top-left-radius: 3px;border-bottom-left-radius: 3px;">
                <i class="fas fa-times-circle " style="color:#fff;"></i>
              </button>
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input file" title="点击上传商品图片 ^_^ " name="goods_img[]" id="validatedInputGroupCustomFile" required>
              <label class="custom-file-label imgName" for="validatedInputGroupCustomFile">{{ "P$i.".Str::afterLast($arrImg[0], '.') }}</label>
            </div>
        </div>
          <div class="file_tip_size"></div>
          <div class="file_tip_type"></div>
          @endfor
        @endif
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
        <!--记录状态-->
        <input class="goods_old_img" type="text" name="goods_old_img" hidden> <!-- 记录old_img -->

        @if(isset($goods_info->id))
          <input class="id" type="text" value="{{ $goods_info->id }}" name="id" hidden>
        @endif

        @foreach (['wrong_type', 'null_data'] as $msg)
          @if(session()->has($msg))
          <span id='tip' msg-data="{{session()->get($msg) }}" hidden></span>
          @endif
        @endforeach
        
      </div>
    </form>

    
    @error('title')
      <input type="text" id="wrong_title" value="{{ $message }}" hidden>
    @enderror
    
    @error('description')
      <input type="text" id="wrong_description" value="{{ $message }}" hidden>
    @enderror

  </div>

</div>
@stop

@section('scriptsAfterJs')
<script>
  $(document).ready(function() {
    if($('#wrong_title').length > 0){
      swal({
        text: $('#wrong_title').val(),
        icon: 'error'
      })
    }else{
      if($('#wrong_description').length > 0){
        swal({
          text: $('#wrong_description').val(),
          icon: 'error'
        })
      } 
    }

    // 判断是否有 错误提示
    msg_data = $('#tip').attr('msg-data')
    if(msg_data){
      console.log(msg_data)
      swal({
        text: msg_data,
        icon: 'warning'
      })
    }


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

      var d_reg = /^0{1}\.{1}[1-9]{1}$/; // 小数-首位可以0，小数位不为0
      var d_reg2 = /^[1-9]{1}\d{0,3}\.{1}\d{1}$/; //  小数-首位不能0，小数位可为0
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
      var d_reg = /^0{1}\.{1}[1-9]{1}$/; // 小数-首位可以0，小数位不为0
      var d_reg2 = /^[1-9]{1}\d{0,3}\.{1}\d{1}$/; //  小数-首位不能0，小数位可为0
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


    // 用于记录 编辑商品 时的图片
    var img_type
    var arrImg = false
    //arrImg = $('.file').eq(0).attr('img_data')
    //console.log(arrImg)
    //arrImg = arrImg.split(',').slice(0, -1) // 转数组， 记录三种情况： url-原图片链接  0-删除  'update'-新图片
    //$('.file').eq(0).attr('img_data', '')
    if ($('.file').eq(0).attr('img_data') != '') {
      arrImg = $('.file').eq(0).attr('img_data')

      console.log(arrImg)
      //arrImg = arrImg.split(',').slice(0, -1) // 转数组， 记录三种情况： url-原图片链接  0-删除  'update'-新图片

      arrImg =arrImg.split(',')

      console.log(arrImg)

      $('.file').eq(0).attr('img_data', '')
      img_type = 'edit'
    } else {
      img_type = 'create'
    }
    for (i = 0; i < $('.file').length; i++) {
      $('.file').eq(i).next().css('border-color', '#28a745')
    }

    // console.log(img_type)

    // 添加商品图片-点击事件
    $('#add').click(function() {

      if ($("input[type='file']").length >= 4) {
        // console.log('最多选择四个图片！')
        swal("最多选择四个图片", {
          buttons: false,
          icon: 'warning',
          timer: 2500
        });
        return false;
      }

      $('.img_file').append(`
      <div class="mt-4 input-group imgFile" style="width:91%;">
        <div class="input-group-append">
          <button class="btn  btn-danger del_btn" type="button" style="top:-1px;border-top-left-radius: 3px;border-bottom-left-radius: 3px;">
            <i class="fas fa-times-circle " style="color:#fff;"></i>
          </button>
        </div>
        <div class="custom-file" >
          <input type="file" class="custom-file-input file" title="点击上传商品图片 ^_^ " name="goods_img[]" id="validatedInputGroupCustomFile"  required>
          <label class="custom-file-label imgName" for="validatedInputGroupCustomFile" >选择图片文件...</label>
        </div>
       </div>
      <div class="file_tip_size"></div>
      <div class="file_tip_type"></div>`)

      if (arrImg) {
        arrImg.push('0') // 添加0，表示空
      }

    })

    $(".img_file ").on("click", "button", function() { // 移除图片
      //console.log( $(this).parent().parent().index() );     // 3 6 9
      if (arrImg) {
        if ($(this).parent().parent().index() == 3) arrImg.splice(1, 1); // 删除下标1
        if ($(this).parent().parent().index() == 6) arrImg.splice(2, 1); // 删除下标2
        if ($(this).parent().parent().index() == 9) arrImg.splice(3, 1); // 删除下标3
      }


      $(this).parent().parent().next().remove()
      $(this).parent().parent().next().remove()
      $(this).parent().parent().remove();
    })


    // 验证上传图片(类型、大小、宽)-change事件
    $(".img_file").on("change", "input", function() {

      if (arrImg) {

        if ($(this).parent().parent().index() == 0) arrImg[0] = 'update'; // 修改下标0
        if ($(this).parent().parent().index() == 3) arrImg[1] = 'update'; // 修改下标1
        if ($(this).parent().parent().index() == 6) arrImg[2] = 'update'; // 修改下标2
        if ($(this).parent().parent().index() == 9) arrImg[3] = 'update'; // 修改下标3
      }

      console.log(arrImg)
      //console.log($(this)[0].files[0])
      reg_img($(this), false, '', arrImg)

      // 验证图片宽高
      // var reader = new FileReader();
      // reader.readAsDataURL(file);
      // reader.onload = function(e) {
      //   var data = e.target.result;
      //   //加载图片获取图片真实宽度和高度
      //   var image = new Image();
      //   image.src = data;
      //   // 图片先加载完，才可以得到图片宽度和高度
      //   image.onload = function() {
      //     var width = image.width;
      //     var height = image.height;
      //     // 验证图片宽高 最小宽和高278和318-最大宽和高480和518
      //     // 宽超过480，则设计一个tip，提示自动裁剪
      //     //console.log('宽：', width)
      //     // if (width > 480) {
      //     //   console.log('自动裁剪')
      //     // }
      //   }
      // }

    })


    // 函数-原图格式还原
    function reg_old_img(img, is_submit, i = '') {
      if (is_submit) {
        img = img.eq(i)
        img.next().css('border-color', '#28a745')
        img.parents('.imgFile').addClass('is-valid').removeClass('is-invalid')
        img.parent().parent().next().addClass('valid-feedback').removeClass('invalid-feedback')
        img.parent().parent().next().next().addClass('valid-feedback').removeClass('invalid-feedback')
        img.parent().parent().next().html('');
        img.parent().parent().next().next().html('');
      }
    }
    // 函数-验证图片
    function reg_img(img, is_submit, i = '', arrImg) {

      if (is_submit) {
        file = img[i].files[0]
        img = img.eq(i)

        img.next().css('border-color', '#28a745')
        img.parents('.imgFile').addClass('is-valid').removeClass('is-invalid')
        img.parent().parent().next().addClass('valid-feedback').removeClass('invalid-feedback')
        img.parent().parent().next().next().addClass('valid-feedback').removeClass('invalid-feedback')
        // img.parent().parent().next().html('');
        // img.parent().parent().next().next().html('');

      } else file = img[0].files[0]

      //console.log(img)
      //console.log(file['name'])

      img_ext = file.type // 获取图片类型
      //console.log(img_ext)
      var png = new RegExp('png');
      var jpg = new RegExp('jpg');
      var jpeg = new RegExp('jpeg');
      var gif = new RegExp('gif');
      img_size = Math.floor(file.size / 1024)

      //console.log(img_size)
      if (png.test(img_ext) || jpg.test(img_ext) || jpeg.test(img_ext) || gif.test(img_ext)) {

        if (img_size > 1024) {
          //console.log('大于200k');

          img.next().css('border-color', '#dc3545')
          img.next().html('选择图片文件...')
          img.parents('.imgFile').addClass('is-invalid').removeClass('is-valid')
          img.parent().parent().next().addClass('invalid-feedback').removeClass('valid-feedback')
          img.parent().parent().next().html('图片大小超过1M，请重新选择！!');
          img.parent().parent().next().next().addClass('valid-feedback').removeClass('invalid-feedback')
          img.parent().parent().next().next().html('');

        } else { // 图片格式、大小都符合
          img.next().css('border-color', '#28a745')
      

          img.next().html(file['name'])
          //img.next().html('xxx')
          img.parents('.imgFile').addClass('is-valid').removeClass('is-invalid')
          img.parent().parent().next().addClass('valid-feedback').removeClass('invalid-feedback')
          img.parent().parent().next().next().addClass('valid-feedback').removeClass('invalid-feedback')
          img.parent().parent().next().html('');
          img.parent().parent().next().next().html('');
          //}
        }
      } else { // 格式不正确
        //console.log('格式不正确');
        img.next().css('border-color', '#dc3545')
        img.next().html('选择图片文件...')
        img.parents('.imgFile').addClass('is-invalid').removeClass('is-valid')
        img.parent().parent().next().next().addClass('invalid-feedback').removeClass('valid-feedback')
        img.parent().parent().next().next().html('不支持该图片格式，请选择 【GIF JPG JPEG PNG】 格式的图片！!');
        img.parent().parent().next().addClass('valid-feedback').removeClass('invalid-feedback')
        img.parent().parent().next().html('');

        if (img_size > 1024) { // 都不正确
          //console.log('都不正确');
          img.next().css('border-color', '#dc3545')
          img.next().html('选择图片文件...')
          img.parents('.imgFile').addClass('is-invalid').removeClass('is-valid')
          img.parent().parent().next().addClass('invalid-feedback').removeClass('valid-feedback')
          img.parent().parent().next().next().addClass('invalid-feedback').removeClass('valid-feedback')
          img.parent().parent().next().html('不支持该图片格式，请重新选择 【GIF JPG JPEG PNG】 格式的图片！!');
          img.parent().parent().next().next().html('图片大小超过1M，请重新选择！!');
        }
      }

    }



    // 立即发布按钮-点击事件
    $('.btn_now').click(function() {

      //console.log(arrImg)
      // 验证
      reg_old_price()
      reg_price()


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
        //console.log($(".file").eq(1).val().length)
        if ($(".file").eq(i).val().length == 0) {
          if (arrImg != false && arrImg[i] != '0') {
            reg_old_img($('input[type=file]'), true, i)
            continue
          }else {
            file = 0
            break
          }

        } else {
          //console.log(123)
          reg_img($('input[type=file]'), true, i, arrImg) // 验证
        }

      }
      console.log(arrImg)
      //console.log($('#description').val())
      if (file == 0 || $('#description').val().length == 0 || $('#title').val().length == 0 || $('#price').val().length == 0 || $('#old_price').val().length == 0) {
        //$('.btn_submit').trigger('click')

        // 弹框提示
        swal({
          text: '你还有未填的选项，无法提交！',
          icon: 'warning'
        })

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
                buttons: ['取消', '确认'],
                dangerMode: true,
              }).then((res) => {
                if (!res) return;

                if(arrImg)  $('.goods_old_img').val(arrImg)     // 也要 arrImg
                else $('.goods_old_img').val(null)
                $('.form_create_goods').submit()
              })
              $('.swal-text').addClass('warning_text'); // 控制swal-text的样式
              $('.swal-footer').css("text-align", "center") // 确认取消按钮-居中
            } else {
              
              //console.log()
              //console.log($('.goods_old_img').val())
              swal({
                title: '确定立即发布?',
                icon: 'warning',
                buttons: ['取消', '确定'],
                dangerMode: true,
              }).then((res) => {
                if (!res) return;
                
                $(this).attr('disabled', 'true')
                $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  Loading...')

                //console.log(arrImg);

                if(arrImg)  $('.goods_old_img').val(arrImg)
                else $('.goods_old_img').val(null)

                $('.form_create_goods').submit()

              })
            }

          }

        }
      }
    })


    // 暂不发布按钮-点击事件
    $('.btn_wait').click(function() {

      // 再次验证
      //console.log($('input[type=file]').length)
      for (var i = 0; i < $('input[type=file]').length; i++) {
        //reg_img($('input[type=file]'),true,i)
      }
      reg_old_price()
      reg_price()

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
        //console.log($(".file").eq(i).val())
        if ($(".file").eq(i).val().length == 0) {
          
          if (arrImg != false && arrImg[i] != '0') {
            reg_old_img($('input[type=file]'), true, i)   // 未改的图片 格式还原
            continue
          }else {
            file = 0
            break
          }
        } else {
          reg_img($('input[type=file]'), true, i,arrImg)
        }
      }
      if (file == 0 || $('#title').val().length == 0 || $('#description').val().length == 0 || $('#price').val().length == 0 || $('#old_price').val().length == 0) {
        //$('.btn_submit').trigger('click')
        swal({
          text: '你还有未填的选项，无法提交！',
          icon: 'warning'
        })

      } else {
        if ($('.is-invalid').length != 0) {
          swal({
            text: '有错误选项，无法提交！',
            icon: 'error'
          })
        } else {

          swal({
            title: '暂不发布',
            text: '?',
            buttons: ['取消', '确定'],
          }).then((res) => {
            if (!res) return;

            $(this).attr('disabled', 'true')
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  Loading...')

            if(arrImg)  $('.goods_old_img').val(arrImg)  // 传 旧图url
            else $('.goods_old_img').val(null)
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
          $('.swal-text').html('暂不发布商品可在 【个人中心】&#10132【我的商品】&#10132【预发布】 中查看')
        }
      }

    })



  })
</script>

@stop