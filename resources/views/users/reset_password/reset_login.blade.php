@extends('layouts.app')
@section('title', '重设密码')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">

        <div class="card-header">重设密码</div>

        <div class="card-body">

          <form method="POST" action="{{ route('verify_reset_password') }}">
            @csrf
            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">QQ邮箱：</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror @if(session()->has('error')) is-invalid @endif" name="email" value="{{ $email }}" disabled autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                @if(session()->has('error'))
                <span class="invalid-feedback">
                  <strong>{{ session()->get('error') }}</strong>
                </span>
                @endif

              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">密码</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">确认密码</label>

              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required >
              </div>
            </div>

            <input id="token" type="" value="{{ $token }}" class="form-control" name="token" hidden >
            <input id="token" type="" value="{{ $email }}" class="form-control" name="email" hidden >

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  重设密码
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