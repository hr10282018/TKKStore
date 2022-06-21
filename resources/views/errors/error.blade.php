
@extends('layouts.app')
@section('title', '错误页面')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">

        <div class="card-header">错误页面</div>

        <div class="card-body text-center">

          <h3> {{$message}} </h3>

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

    console.log(document.referrer)
    $('#back').click(function() {
      
      window.location.href='http://onestore.tkk/goods'
      
    })


  })
</script>

@stop