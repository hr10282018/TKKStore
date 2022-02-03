@extends('users.edit._edit')

@section('edit_info')

<div class="card ml-4 mb-4" style="width: 875px;">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <div class="row mt-2">
        <i class="fas fa-lock ml-3 mr-2" style="font-size: 20px;"></i>
        <h4 style="line-height: 20px;">修改密码</h4>
      </div>
    </li>
  </ul>

  <div class="card-body">
    <form action="{{ route('user_edit_password_check',$user) }}" method="POST">
      <!-- <input type="hidden" name="_method" value="PUT"> -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group " style="width:810px;">


        <label for="u_pwd" style="color: #969696;font-weight:bold">邮箱</label>
        <div class="row ml-0">

          <input type="" class="form-control" id="u_pwd" style="width:405px;" value="{{ $user->email }}" disabled>
          <div style="line-height:35px;color:#636b6f" class="ml-2">您的邮箱</div>
        </div>
      </div>

      <div class="form-group " style="width:810px;">
        <label for="u_pwd" style="color: #969696;font-weight:bold">密码</label>
        <div class="row ml-0">
          <input id="u_pwd" type="password" class="form-control @error('password') is-invalid @enderror" style="width:405px;" name="password" required autocomplete="new-password">
          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>

      <div class="form-group " style="width:810px;">
        <label for="u_pwd2" style="color: #969696;font-weight:bold">确认密码</label>
        <div class="row ml-0">
          <input type="password" name="password_confirmation" class="form-control" id="u_pwd2" style="width:405px;" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2"></div>
        </div>
      </div>

      <div class="form-group form-check mb-2" style=" width:98px;right:20px">
        <button type="submit" class="btn " style="margin-right:10px;width:98px;color: white;background-color: #f4645f;border-color: #f4645f;font-weight:bold">
          确认修改
        </button>
      </div>

    </form>
  </div>

</div>

@stop
