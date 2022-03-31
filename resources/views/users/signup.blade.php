
@extends('layouts.app')
@section('title', '欢迎注册')

@section('content')
<div class="offset-md-4 col-md-4 " >
  <div class="card"  id="signup">
    <div class="card-header">
      <h5>注册 ^_^</h5>
    </div>
    <div class="card-body " >
      @include('shared._errors')
      <form method="POST" action="{{ route('users.register') }}">
        {{ csrf_field() }}

          <div class="form-group ml-5">
            <label for="name" class="form-inline" />
            名称：<input type="text" style="width: 223px;" maxlength="25"  name="name" id="user_name" class="{{ $errors->has('name') ? ' is-invalid' : '' }} form-control uname " value="{{ old('name') }}" placeholder="请输入您的名称" required>
            <div class="offset-md-2 {{ $errors->has('name') ? ' invalid-feedback' : '' }}" id="uname_tip">
              <strong>{{ $errors->first('name') }}</strong>
            </div>

          </div>

          <div class="form-group ml-5">
            <label for="email" class="form-inline" />邮箱：
            <input type="text" style="width: 223px;" maxlength="255"  name="email" id="user_email" class="{{ $errors->has('email') ? ' is-invalid' : '' }} form-control uemail" value="{{ old('email') }}" placeholder="请输入您真实的QQ邮箱" required>
            <div class="offset-md-2 {{ $errors->has('email') ? ' invalid-feedback' : '' }}" id="uemail_tip">
              <strong>{{ $errors->first('email') }}</strong>
            </div>
          </div>

          <div class="form-group ml-5">
            <label for="password" class="form-inline" />密码：
            <input type="password" style="width: 223px;" maxlength="255" name="password" id="user_pwd" class="form-control upwd" value="{{ old('password') }}" placeholder="密码不能少于6位" required>
            <div class="offset-md-2 {{ $errors->has('password') ? ' invalid-feedback' : '' }}" id="upwd_tip">
            <strong>{{ $errors->first('password') }}</strong>
            </div>
          </div>

          <div class="form-group ">
            <label for="password_confirmation" class="form-inline comfirm_pwd " />确认密码：
            <input type="password" style="width: 223px;" maxlength="255" name="password_confirmation" id="user_pwd2" class="form-control upwd2" value="{{ old('password_confirmation') }}" required>
            <div class="offset-md-3" id="upwd2_tip">
            </div>

          </div>

          <!-- 验证码 -->
          <div class="form-group  ml-4">
              <label for="captcha" class="form-inline verify" />验证码：
              <input autocomplete="off" id="captcha" maxlength="6" class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }} " name="captcha" required>
              <div id="captcha_tip" class="offset-md-2  {{ $errors->has('captcha') ? ' invalid-feedback' : '' }}" >
                <strong>{{ $errors->first('captcha') }}</strong>
              </div>
              <div  class="ml-5">
                <img class="thumbnail captcha col-md-11 mt-3 mb-2" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
              </div>
            </div>

          <button type="submit" autocomplete="off" class="form-group btn_reg btn btn-primary offset-md-3" id="btn_register" disabled>注册</button>
      </form>
    </div>
  </div>
</div>

@stop

@section('scriptsAfterJs')
<script>
  $(document).ready(function() {

    // 验证用户名
    $('#user_name').blur(function(){
      // 长度3-25
      // ajax-用户名唯一
      if($('#user_name').val().length>=3 && $('#user_name').val().length<=25 ){
        axios.get('/ajax_name/' + $(this).val()).then(function(res){
          //console.log(res.data)
          if(JSON.stringify(res.data)=='false'){
            $('#user_name').addClass('is-invalid').removeClass('is-valid');
            $("#uname_tip").addClass('invalid-feedback').removeClass('valid-feedback');
            $("#uname_tip").html('<strong>该名称已被注册，请重新填写！!</strong>');
          }else if(JSON.stringify(res.data)=='true'){
            $('#user_name').addClass('is-valid').removeClass('is-invalid');
            $("#uname_tip").addClass('valid-feedback').removeClass('invalid-feedback');
            $("#uname_tip").html('');
          }
          is_reg()
        },function(error){    // 请求错误
          if(error.response.status === 422){      // 表示验证不通过
            console.log(error.response.data.errors)
          }
          console.log(error.response.data.errors)
        })
      }else{
        $('#user_name').addClass('is-invalid').removeClass('is-valid');
        $("#uname_tip").addClass('invalid-feedback').removeClass('valid-feedback');
        $('#uname_tip').html('<strong>名称长度为 3~25 ！！</strong>')
        is_reg()
      }
    })

    // 验证邮箱
    $('#user_email').blur(function(){
      //console.log('邮箱')
      var email = $("#user_email").val();
      var reg=/^[a-zA-Z\d]{8,}@qq.com$/;
      var res_data
      if(reg.test(email)){     // 邮箱格式正确
        axios.get('/ajax_email/'+ email).then(function(res){
          // console.log(res.data)
          res_data=res.data
          if(JSON.stringify(res.data)=='false'){
            $("#user_email").addClass('is-invalid').removeClass('is-valid');
            $("#uemail_tip").addClass('invalid-feedback').removeClass('valid-feedback');
            $("#uemail_tip").html('<strong>该邮箱已被注册，请重新填写！!</strong>');
          }else if(JSON.stringify(res.data)=='true'){
            $("#user_email").addClass('is-valid').removeClass('is-invalid');
            $("#uemail_tip").addClass('valid-feedback').removeClass('invalid-feedback');
            $("#uemail_tip").html('');
          }
          is_reg()
        })
      }else{
        //console.log('wrong')
        $('#user_email').addClass('is-invalid').removeClass('is-valid');
        $("#uemail_tip").addClass('invalid-feedback').removeClass('valid-feedback');
        $('#uemail_tip').html('<strong>请输入正确的QQ邮箱格式 ！！</strong>')
        is_reg()
      }

    })

    // 验证密码
    $('#user_pwd').blur(function(){
      //console.log('密码')
      if($('#user_pwd').val().length==0){
        $('#user_pwd').addClass('is-invalid').removeClass('is-valid');
        $("#upwd_tip").addClass('invalid-feedback').removeClass('valid-feedback');
        $('#upwd_tip').html('<strong>请输入密码 ！！</strong>')
      }else if($('#user_pwd').val().length>0 && $('#user_pwd').val().length<6){
        $('#user_pwd').addClass('is-invalid').removeClass('is-valid');
        $("#upwd_tip").addClass('invalid-feedback').removeClass('valid-feedback');
        $('#upwd_tip').html('<strong>密码长度不能小于6位 ！！</strong>')
      }else{
        $('#user_pwd').addClass('is-valid').removeClass('is-invalid');
        $("#upwd_tip").addClass('valid-feedback').removeClass('invalid-feedback');
        $("#upwd_tip").html('');
      }

      is_reg();
    })
    // 确认密码
    $('#user_pwd2').blur(function(){
      //console.log('密码2')
      if($('#user_pwd').val().length == 0){
        $('#user_pwd2').addClass('is-invalid').removeClass('is-valid');
        $("#upwd2_tip").addClass('invalid-feedback').removeClass('valid-feedback');
        $('#upwd2_tip').html('<strong>请输入密码 ！！</strong>')
      }
      else if(($('#user_pwd').val() != $('#user_pwd2').val()) ){
        //console.log('密码不一致')
        $('#user_pwd2').addClass('is-invalid').removeClass('is-valid');
        $("#upwd2_tip").addClass('invalid-feedback').removeClass('valid-feedback');
        $('#upwd2_tip').html('<strong>两次密码输入不一致 ！！</strong>')
      }else{
        $('#user_pwd2').addClass('is-valid').removeClass('is-invalid');
        $("#upwd2_tip").addClass('valid-feedback').removeClass('invalid-feedback');
        $("#upwd2_tip").html('');
      }

      is_reg();
    })

    // 验证码
    $('#captcha').blur(function(){
      if($('#captcha').val().length > 0 ){
        $('#captcha').removeClass('is-valid').removeClass('is-invalid');
        $("#captcha_tip").removeClass('valid-feedback').removeClass('invalid-feedback');
        $("#captcha_tip").html('');
      }

      is_reg()
    })


    // 自定函数-判断是否有错误样式，注册按钮是否可用
    function is_reg(){
      var name=$('#user_name').val().length
      var email=$('#user_email').val().length
      var pwd=$('#user_pwd').val().length
      var pwd2=$('#user_pwd2').val().length
      var captcha=$('#captcha').val().length


      if($('div').hasClass('invalid-feedback') ){   // 有错误提示
        $('.btn_reg').attr('disabled','true')
      }else{
        if(name==0 ){       // 输入为空
          $('.btn_reg').attr('disabled','true')
        }else if(email==0){
          $('.btn_reg').attr('disabled','true')
        }else if(pwd==0){
          $('.btn_reg').attr('disabled','true')
        }else if(pwd2==0){
          $('.btn_reg').attr('disabled','true')
        }else if(captcha==0){
          $('.btn_reg').attr('disabled','true')
        }else{
          // 输入不为空 && 且没有错误提示
          $('.btn_reg').removeAttr('disabled')    // 可以使用注册按钮
        }

      }
    }

  })

</script>
@stop
