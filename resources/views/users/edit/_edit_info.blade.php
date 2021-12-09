@extends('users.edit._edit')

@section('edit_info')

<div class="card ml-4 mb-4" style="width: 875px;">
  <ul class="list-group list-group-flush">

    <li class="list-group-item">
      <div class="row mt-2">
        <i class="far fa-edit ml-3 mr-2" style="font-size: 20px;"></i>
        <h4 style="line-height: 20px;">修改资料</h4>
      </div>

    </li>

  </ul>

  <div class="card-body">
    <form>
      <div class="form-group " style="width:810px;">
        <label for="u_name" style="color: #969696;font-weight:bold">用户名</label>
        <div class="row ml-0">
          <input type="" class="form-control" id="u_name" style="width:405px;" value="{{ $user->name }}" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2">你的用户名。长度为3-25字符</div>
        </div>
      </div>

      <div class="form-group" style="width:810px;">
        <label for="sex">性别</label>
        <select class="form-control" id="sex" style="width:405px;">
          <option>男</option>
          <option>女</option>
        </select>
      </div>

      <div class="form-group">
        <label for="u_signature" style="color: #969696;font-weight:bold;" >个性签名</label>
        <div class="row ml-0">
          <input type="" class="form-control" id="u_eamil" style="width:405px;" value="{{ $user->signature }}" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2">建议长度不超过。。</div>
        </div>
      </div>

      <div class="form-group">
        <label for="u_email" style="color: #969696;font-weight:bold;" >QQ邮箱</label>
        <div class="row ml-0">
          <input type="email" class="form-control" id="u_eamil" style="width:405px;" value="{{ $user->email }}" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2">请填写您有效的QQ邮箱，如1902422119@qq.com</div>
        </div>
      </div>

      <div class="form-group">
        <label for="u_phone" style="color: #969696;font-weight:bold;">手机号码</label>
        <div class="row ml-0">
          <input type="phone" class="form-control" id="u_phone" style="width:405px;">
          <div style="line-height:35px;color:#636b6f" class="ml-2">请填写您的手机号</div>
        </div>
      </div>

      <div class="form-group">
        <label for="u_university" style="color: #969696;font-weight:bold">学校</label>
        <input type="" class="form-control" id="u_university" style="width:405px;">
      </div>
      <div class="form-group" style="color: #969696;font-weight:bold">
        <label for="u_faculty">院系</label>
        <input type="" class="form-control" id="u_faculty" style="width:405px;">
      </div>
      <div class="form-group" style="color: #969696;font-weight:bold">
        <label for="u_stuID">学号</label>
        <input type="" class="form-control" id="u_stuID" style="width:405px;">
      </div>
      <div class="form-group" style="color: #969696;font-weight:bold">
        <label for="u_rname">真实姓名</label>
        <input type="" class="form-control" id="u_rname" style="width:405px;">
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
