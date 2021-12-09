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

      <div class="form-group border" style="height:48px;">
        <input type="file" name="avatar" data-toggle="tooltip" data-placement="bottom" class="form-control-file  ml-2 " title="请上传 (png,jpg,gif,jpeg) 格式的图片" style="margin-top: 12px;" required/>
      </div>

      <div class="form-group form-check mb-2 mt-2" style=" width:98px;right:20px">
        <button type="submit" class="btn " style="margin-right:10px;width:98px;color: white;background-color: #f4645f;border-color: #f4645f;font-weight:bold">
          上传头像
        </button>
      </div>

    </form>
  </div>


</div>


@stop
