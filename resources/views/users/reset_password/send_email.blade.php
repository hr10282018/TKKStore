@extends('layouts.app')
@section('title', '重设密码')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">

        <div class="card-header">重设密码</div>

        <div class="card-body">
         
          <form method="POST" action="{{ route('verify_password_send_email') }}">
            @csrf
            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">QQ邮箱：</label>

              <div class="col-md-6">
                <input id="email" placeholder="请填写你的QQ邮箱" type="email" class="form-control @error('email') is-invalid @enderror @if(session()->has('email_no_pwd')) is-invalid @endif" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                @if(session()->has('email_no_pwd'))
                <span class="invalid-feedback">
                  <strong>{{ session()->get('email_no_pwd') }}</strong>
                </span>
                @endif

              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  发送重设密码链接
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@stop