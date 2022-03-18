@extends('users.edit._edit')

@section('edit_info')
<!-- 修改头像 -->
<div class="card ml-4 mb-4" style="width: 875px;">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <div class="row mt-2">
        <i class="far fa-image mr-2 ml-3" style="font-size: 22px;color:#636b6f"></i>

        <h4 style="line-height: 20px;color:#636b6f">修改头像</h4>
      </div>

    </li>
  </ul>

  <div class="card-body">
    <!-- <i class="fas fa-info-circle"></i> -->


    <form action="{{ route('user_edit_avatar_check', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      @if($user->avatar)
      <br>
      <img class="thumbnail img-responsive" src="{{ $user->avatar }}" style="width: 325px;height:321px" />
      @endif

      <div class="mt-3">
        <p style="color:#636b6f;font-size:17px">请选择图片：</p>
      </div>


      <div class=" input-group imgFile" style="width:91%;">
        <div class="input-group-append"></div>
        <div class=" custom-file">
          <!-- <input type="file" name="avatar" data-toggle="tooltip" data-placement="bottom" class="form-control-file  ml-2 avatar" title="请上传 (png,jpg,gif,jpeg) 格式的图片" style="margin-top: 12px;" required/> -->
          <input id="avatar" type="file" title="请上传 【PNG JPG GIF JPEG】 格式的图片 ^_^ " class="custom-file-input file" name="avatar" id="validatedInputGroupCustomFile" autocomplete="off">
          <label class="custom-file-label " for="validatedInputGroupCustomFile">选择图片...</label>
        </div>
      </div>
      <div class=" file_tip_size"> </div>
      <div class=" file_tip_type"> </div>


      <div class="form-group form-check mb-2 mt-3" style=" width:98px;right:20px">
        <button type="button" class="btn btn_click" style="margin-right:10px;width:98px;color: white;background-color: #f4645f;border-color: #f4645f;font-weight:bold">
          上传头像
        </button>
        <button type="submit" class="btn btn_submit" style="margin-right:10px;width:98px;color: white;background-color: #f4645f;border-color: #f4645f;font-weight:bold" hidden>

        </button>
      </div>

    </form>
    @foreach (['wrong_type', 'null_data'] as $msg)
    @if(session()->has($msg))
    <span id='tip' msg-data="{{session()->get($msg) }}" hidden></span>
    @endif
    @endforeach

  </div>


</div>
@stop


@section('scriptsAfterJs')
<script>
  $(document).ready(function() {
    // 判断是否有 错误提示
    msg_data = $('#tip').attr('msg-data')
    if (msg_data) {
      console.log(msg_data)
      swal({
        text: msg_data,
        icon: 'warning'
      })
    }

    // 函数-验证图片
    function reg_avatar(avatar) {
      // console.log(avatar[0].files[0])
      // return false;

      file = avatar[0].files[0]
      console.log(file)

      img_ext = file.type // 获取图片类型
      var png = new RegExp('png');
      var jpg = new RegExp('jpg');
      var jpeg = new RegExp('jpeg');
      var gif = new RegExp('gif');
      img_size = Math.floor(file.size / 1024)

      if (png.test(img_ext) || jpg.test(img_ext) || jpeg.test(img_ext) || gif.test(img_ext)) {

        if (img_size > 200) {
          //console.log('大于200k');
          avatar.next().css('border-color', '#dc3545')
          avatar.next().html('选择图片文件...')
          avatar.parents('.imgFile').addClass('is-invalid').removeClass('is-valid')
          avatar.parent().parent().next().addClass('invalid-feedback').removeClass('valid-feedback')
          avatar.parent().parent().next().html('图片大小超过200K，请重新选择！!');
          avatar.parent().parent().next().next().addClass('valid-feedback').removeClass('invalid-feedback')
          avatar.parent().parent().next().next().html('');

        } else { // 图片格式、大小都符合
          avatar.next().css('border-color', '#28a745')
          console.log(1)
          avatar.next().html(file['name'])
          avatar.parents('.imgFile').addClass('is-valid').removeClass('is-invalid')
          avatar.parent().parent().next().addClass('valid-feedback').removeClass('invalid-feedback')
          avatar.parent().parent().next().next().addClass('valid-feedback').removeClass('invalid-feedback')
          avatar.parent().parent().next().html('');
          avatar.parent().parent().next().next().html('');
          //}
        }
      } else { // 格式不正确
        //console.log('格式不正确');
        avatar.next().css('border-color', '#dc3545')
        avatar.next().html('选择图片文件...')
        avatar.parents('.imgFile').addClass('is-invalid').removeClass('is-valid')
        avatar.parent().parent().next().next().addClass('invalid-feedback').removeClass('valid-feedback')
        avatar.parent().parent().next().next().html('不支持该图片格式，请选择 【GIF JPG JPEG PNG】 格式的图片！!');
        avatar.parent().parent().next().addClass('valid-feedback').removeClass('invalid-feedback')
        avatar.parent().parent().next().html('');

        if (img_size > 200) { // 都不正确
          //console.log('都不正确');
          avatar.next().css('border-color', '#dc3545')
          avatar.next().html('选择图片文件...')
          avatar.parents('.imgFile').addClass('is-invalid').removeClass('is-valid')
          avatar.parent().parent().next().addClass('invalid-feedback').removeClass('valid-feedback')
          avatar.parent().parent().next().next().addClass('invalid-feedback').removeClass('valid-feedback')
          avatar.parent().parent().next().html('不支持该图片格式，请重新选择 【GIF JPG JPEG PNG】 格式的图片！!');
          avatar.parent().parent().next().next().html('图片大小超过200K，请重新选择！!');
        }
      }
    }


    $('#avatar').change(function() {
      reg_avatar($(this))
    })

    $('.btn_click').click(function() {
      if ($('#avatar').val().length == 0) {
        swal({
          text: '请上传图片！',
          icon: 'warning'
        })
      } else {
        reg_avatar($('#avatar'))

        if ($('.is-invalid').length != 0) {
          swal({
            text: '有错误选项，无法提交！',
            icon: 'error'
          })
        } else {
          $('.btn_submit').trigger('click')
        }

      }

    })
  })
</script>

@stop