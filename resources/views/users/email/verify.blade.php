@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">验证您的邮箱！</div>

        <div class="card-body">
          @if (session('resent'))
          <div class="alert alert-success" role="alert">
            新的验证链接已发送到您的电子邮件地址
          </div>
          @endif

          在继续之前，请检查您的电子邮件以获取验证链接，
          如果您没有收到,
          <form class="d-inline" method="POST" action="{{ route('second_send_email',$user->id) }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">点击重新发送 邮箱</button>.
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
