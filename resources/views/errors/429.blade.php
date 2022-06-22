@extends('layouts.app')
@section('title', '错误页面')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">

        <div class="card-header">错误页面</div>

        <div class="card-body text-center">

          <h3> 提交频率过高，休息1分钟再试试吧！ </h3>

          <button id="back" class="btn btn-primary" href="">返回</button>

        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('scriptsAfterJs')
<script>
  $(document).ready(function() {

   
    $('#back').click(function() {
      if(window.location.href === document.referrer){
        window.location.href='{{ env("APP_URL") }}'+'/goods'
      }else{
        window.location.href = document.referrer
      }
    })


  })
</script>

@stop