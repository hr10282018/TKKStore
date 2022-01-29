
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
            名称：<input type="text" name="name" id="r_input" class="form-control uname " value="{{ old('name') }}" placeholder="请输入您的名称" required>
            <div class="valid-feedback offset-md-2" id="uname_tip">
              此名称已被注册！
            </div>
          </div>

          <div class="form-group ml-5">
            <label for="email" class="form-inline" />邮箱：
            <input type="text" name="email" id="r_input" class="form-control uemail" value="{{ old('email') }}" placeholder="请输入您真实的QQ邮箱" required>
            <div class="valid-feedback offset-md-2" id="uemail_tip">
              此邮箱已被注册！
            </div>
            <div class="valid-feedback offset-md-2"  id="uemail_tip2">
              请输入您正确的QQ邮箱！
            </div>
          </div>

          <div class="form-group ml-5">
            <label for="password" class="form-inline" />密码：
            <input type="password" name="password" id="r_input" class="form-control upwd" value="{{ old('password') }}" placeholder="密码不能少于6位" required>
            <div class="valid-feedback offset-md-2" id="upwd_tip">
              密码长度不能小于6位！
            </div>
          </div>

          <div class="form-group ">
            <label for="password_confirmation" class="form-inline comfirm_pwd " />确认密码：
            <input type="password" name="password_confirmation" id="r_input" class="form-control upwd2" value="{{ old('password_confirmation') }}" required>
            <div class="valid-feedback offset-md-3" id="upwd2_tip">
              两次密码输入不一致！
            </div>
            <div class="valid-feedback offset-md-3" id="upwd2_tip2">
              密码长度不能小于6位！
            </div>
          </div>

          <!-- 验证码 -->
          <div class="form-group  ml-4">
              <label for="captcha" class="form-inline verify" />验证码：
              <input id="captcha"  class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }} " name="captcha" required>
              <div class="offset-md-2  {{ $errors->has('captcha') ? ' invalid-feedback' : '' }}" >
                  <strong>{{ $errors->first('captcha') }}</strong>
                </div>
              <div  class="ml-5">
                <img class="thumbnail captcha col-md-11 mt-3 mb-2" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
              </div>
            </div>

          <button type="submit" class="btn btn-primary offset-md-3" id="btn_register" disabled>注册</button>
      </form>
    </div>
  </div>
</div>

@stop
