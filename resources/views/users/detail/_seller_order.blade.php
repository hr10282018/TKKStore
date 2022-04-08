<!-- 出售订单  -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;margin-bottom:75px">
  <div class="card ">
    <div class="card-body">
      <div class="row ">
        <i class="far fa-envelope mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
        <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
          {{-- $user->name --}}
          name
          <span style="letter-spacing:2px"> 出售订单</span>
          （{{-- count($user->bookingsUser) --}}1）
        </h1>
      </div>
    </div>

    <hr style="width: 650px;margin:0 auto;">

    <div class="card-body ">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">待发送</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">已发送</a>
        </li>

      </ul>

      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">xxx</div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">yyy</div>
      </div>

      <!-- 日期选择器-->
      <!-- <div id="sandbox-container">
        <div class="input-group date">
          <input type="text" class="form-control">
          <span class="input-group-addon"> <i class="fas fa-history"></i> </span>
        </div>
      </div> -->
      
    </div>
  </div>
</div>

@stop

@section('scriptsAfterJs')
<script src="https://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<script src="/js/dist/js/bootstrap-datepicker.min.js"></script>
<script src="/js/dist/locales/bootstrap-datepicker.zh-CN.min.js" charset="UTF-8"></script>

<script>
  $(document).ready(function() {
    $('#sandbox-container .input-group.date').datepicker({
      language:'zh-CN'
    })

  })

</script>

@stop
