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
    <form id="info_form" autocomplete="off" action="{{ route('user_edit_check',$user) }}" method="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group " style="width:810px;">
        <label for="u_name" style="color: #969696;font-weight:bold">用户名 <span class="ml-2" style="color:red;font-size: 18px;float:right">*</span></label>
        <div class="row ml-0">
          <input class="form-control user_name" id="u_name" style="width:405px;" maxlength="25"  value="{{ $user->name }}" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2">你的用户名，建议长度为3~25</div>
          <div class="wrong_tip_name"></div>
        </div>
      </div>

      <div class="form-group" style="width:810px;">

        <label for="sex" style="color: #969696;font-weight:bold;">性别 <span class="ml-2" style="color:red;font-size: 18px;float:right">*</span></label>
        <select class="form-control " id="sex" style="width:405px;">
          <option @if($user->sex=='男') selected @endif >男</option>
          <option @if($user->sex=='女') selected @endif>女</option>
        </select>
      </div>

      <div class="form-group">
        <label for="u_signature" style="color: #969696;font-weight:bold;">个性签名</label>
        <div class="row ml-0">
          <input class="form-control" id="u_signature" style="width:405px;" maxlength="50" value="{{ $user->signature }}" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2">建议长度不超过50</div>
        </div>
      </div>

      <div class="form-group">
        <label for="u_email" style="color: #969696;font-weight:bold;">QQ邮箱 <span class="ml-2" style="color:red;font-size: 18px;float:right">*</span></label>
        <div class="row ml-0">
          <input type="email" class="form-control user_email" id="u_email" style="width:405px;" value="{{ $user->email }}" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2">请填写您有效的QQ邮箱，如1902422119@qq.com</div>
          <div class="wrong_tip_email"></div>

        </div>
      </div>

      <div class="form-group">
        <label for="u_phone" style="color: #969696;font-weight:bold;">手机号码</label>
        <div class="row ml-0">
          <input type="phone" class="form-control user_phone" id="u_phone" style="width:405px;" maxlength="11" value="{{ $user->phone }}">
          <div style="line-height:35px;color:#636b6f" class="ml-2">您的手机号，长度必须为 11位</div>
          <div class="wrong_tip_phone"></div>
        </div>
      </div>

      <div class="form-group">
        <label for="u_university" style="color: #969696;font-weight:bold">学校</label>
        <input type="" class="form-control" id="u_university" style="width:405px;" value="{{ $user->university }}">
      </div>
      <div class="form-group" style="color: #969696;font-weight:bold">
        <label for="u_faculty">院系</label>
        <input type="" class="form-control" id="u_faculty" style="width:405px;" value="{{ $user->faculty }}">
      </div>
      <div class="form-group" style="color: #969696;font-weight:bold">
        <label for="u_stuID">学号</label>
        <input type="" class="form-control" id="u_stuID" style="width:405px;" value="{{ $user->number }}">
      </div>
      <div class="form-group" style="color: #969696;font-weight:bold">
        <label for="u_rname">真实姓名</label>
        <input type="" class="form-control" id="u_rname" style="width:405px;" value="{{ $user->r_name }}">
      </div>

      <div class="form-group form-check mb-2" style=" width:98px;right:20px">
        <button type="button" class="btn btn-danger btn_edit_info" style="margin-right:10px;width:98px;color: white;border-color: #f4645f;font-weight:bold">
          确认修改
        </button>
      </div>
    </form>
  </div>

</div>
@stop

@section('scriptsAfterJs')
<script>
  $(document).ready(function() {
    // 用户名验证
    var current_name=$(".user_name").val();
    $(".user_name").blur(function(){
      if($(this).val()==''){
        $(this).addClass('is-invalid').removeClass('is-valid');
        $(".wrong_tip_name").addClass('invalid-feedback').removeClass('valid-feedback');
        $(".wrong_tip_name").html('<span>请填写用户名！!</span>');
      }
      if($(this).val().length<3 && $(this).val().length>0){
        $(this).addClass('is-invalid').removeClass('is-valid');
        $(".wrong_tip_name").addClass('invalid-feedback').removeClass('valid-feedback');
        $(".wrong_tip_name").html('<span>用户名长度不能小于3！!</span>');
      }
      if($(this).val().length>=3 && $(this).val().length<=25){
        if($(".user_name").val() == current_name ){
          $(".user_name").removeClass('is-valid is-invalid');
        }else{
          axios.get('/ajax_name/' + $(this).val())
            .then(function(res) {
              if(JSON.stringify(res.data)=='false'){
                $(".user_name").addClass('is-invalid').removeClass('is-valid');
                $(".wrong_tip_name").addClass('invalid-feedback').removeClass('valid-feedback');
                $(".wrong_tip_name").html('<span>该用户名已被注册，请重新填写！!</span>');

              }else if(JSON.stringify(res.data)=='true'){
                $(".user_name").addClass('is-valid').removeClass('is-invalid');
                $(".wrong_tip_name").addClass('valid-feedback').removeClass('invalid-feedback');
                $(".wrong_tip_name").html('');
              }
            })
        }
      }
    });

    // 邮箱验证
    var current_email= $(".user_email").val();
    $(".user_email").blur(function(){
      var email = $(".user_email").val();
      var reg=/^[a-zA-Z\d]{8,}@qq.com$/;
      if(reg.test(email)){      // 邮箱格式正确
        if(email==current_email){
          $(".user_email").removeClass('is-valid is-invalid');
        }else{
          axios.get('/ajax_email/'+ email)
          .then(function(res){
            //console.log('1')
            if(JSON.stringify(res.data)=='false'){
              $(".user_email").addClass('is-invalid').removeClass('is-valid');
              $(".wrong_tip_email").addClass('invalid-feedback').removeClass('valid-feedback');
              $(".wrong_tip_email").html('<span>该邮箱已被注册，请重新填写！!</span>');
            }else if(JSON.stringify(res.data)=='true'){
              $(".user_email").addClass('is-valid').removeClass('is-invalid');
              $(".wrong_tip_email").addClass('valid-feedback').removeClass('invalid-feedback');
              $(".wrong_tip_email").html('');
            }
          })
        }
      }else{
          $(this).addClass('is-invalid').removeClass('is-valid');
          $(".wrong_tip_email").addClass('invalid-feedback').removeClass('valid-feedback');
        if(email==''){
          $(".wrong_tip_email").html('<span>请填写您的邮箱！！</span>');
        }else{
          $(".wrong_tip_email").html('<span>您的邮箱格式不正确，请重新填写！！</span>');
        }
      }
    })

    // 手机号验证
    var current_phone= $(".user_phone").val();
    $('.user_phone').blur(function(){
      if(current_phone == $(".user_phone").val()){
        $('.user_phone').removeClass('is-valid').removeClass('is-invalid');
        $(".wrong_tip_phone").removeClass('valid-feedback').removeClass('invalid-feedback');
        $(".wrong_tip_phone").html('');
      }else{
        if( $('.user_phone').val().length>0 && $('.user_phone').val().length<11){
          
          $('.user_phone').addClass('is-invalid').removeClass('is-valid');
          $(".wrong_tip_phone").addClass('invalid-feedback').removeClass('valid-feedback');
          $(".wrong_tip_phone").html('<span>手机号码长度必须为 11位 ！！</span>');
        }else if($('.user_phone').val().length==11){
          
          $('.user_phone').addClass('is-valid').removeClass('is-invalid');
          $(".wrong_tip_phone").addClass('valid-feedback').removeClass('invalid-feedback');
          $(".wrong_tip_phone").html('');
          
        }else if($('.user_phone').val().length==0){
          
          $('.user_phone').removeClass('is-valid').removeClass('is-invalid');
          $(".wrong_tip_phone").removeClass('valid-feedback').removeClass('invalid-feedback');
          $(".wrong_tip_phone").html('');
        }
      }

    })

    // 确认修改-点击事件
    $('.btn_edit_info').click(function() {
      // 获取用户信息
      var user_data={
        name: $('.user_name').val(),
        sex: $('#sex option:selected').val(),
        email: $('.user_email').val(),
        signature:$('#u_signature').val(),
        phone:$('#u_phone').val(),
        university:$('#u_university').val(),
        faculty:$('#u_faculty').val(),
        number:$('#u_stuID').val(),
        r_name:$('#u_rname').val(),
        email_cg:'',    // 传递一个变量到控制器-表示邮箱是否修改
      }
      if($('.is-invalid').length!=0){   // 表示还有错误选项，无法提交修改
        swal({
          text: '有错误选项，无法提交！',
          icon: 'error'
        })
      }else{                            // 可以提交信息表单
        if(current_email != $(".user_email").val()){        // 用户修改了邮箱
          user_data.email_cg='true';      // 修改了邮箱
          //console.log(user_data);
          swal({
            title: '你确定吗?',
            text: "修改邮箱后需要重新登录进行邮箱验证！",
            icon: 'warning',
            buttons: ['取消', '确定'],
            dangerMode: true,
          }).then((res) => {
            if (!res) {
              return;
            }
            axios.post( '{{ route('user_edit_check', ['user'=> $user->id]) }}', user_data)
            .then(function(res){ // 请求成功执行此函数
              //console.log(res.data)
              swal({
                title:'修改成功',
                icon:'success',
                closeOnClickOutside: false}).then(function(url){
                  if(url){
                    location.href = '{{ route('login') }}';
                  }
                // location.reload();
              });
              $('.swal-button').text('重新登录');   // swal按钮样式-文字

            },function(error){   // 请求失败执行此函数
              $(".is-valid").removeClass('is-valid');   // 所有成功样式清除
              console.log(error.response.status);

              var html = '<div>';
              if(error.response.status === 429){    // 429 频率限制
                html += '您提交频率过高，休息1分钟再试试吧！'+'<br>';
              }
              if(error.response.status === 422){
                _.each(error.response.data.errors, function (errors) {
                  _.each(errors, function (error) {
                    html += error+'<br>';
                  })
                });
              }
              html += '</div>';
              swal({content: $(html)[0], icon: 'error',closeOnClickOutside: false,})
              //console.log(error.response.data.errors)
            })
          });
          $('.swal-text').addClass('warning_text'); // 控制swal-text的样式
          $('.swal-footer').css("text-align","center")  // 确认取消按钮-居中

        }else{          // 用户没有修改邮箱
          user_data.email_cg='false';
          //console.log(user_data)
          axios.post( '{{ route('user_edit_check', ['user'=> $user->id]) }}', user_data)
          .then(function(res){
            swal('修改成功', '', 'success').then(function(){
                location.reload();
            });
          },function(error){
            $(".is-valid").removeClass('is-valid');   // 所有成功样式清除
              var html = '<div>';
              if(error.response.status === 429){    // 429 频率限制
                html += '您提交频率过高，休息1分钟再试试吧！'+'<br>';
              }
              if(error.response.status === 422){
                _.each(error.response.data.errors, function (errors) {
                  _.each(errors, function (error) {
                    html += error+'<br>';
                  })
                });
              }
              html += '</div>';
              swal({content: $(html)[0], icon: 'error',closeOnClickOutside: false,})
          })
        }
      }

    })

  })
</script>
@stop
