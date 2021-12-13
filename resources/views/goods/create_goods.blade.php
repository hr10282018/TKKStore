@extends('layouts.app')
@section('title', '首页')

@section('content')

<div class="card ml-4 " style="width: 875px;left:250px;  margin-bottom:100px;">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <div class="row mt-2">
        <i class="far fa-edit ml-3 mr-2" style="font-size: 20px;"></i>
        <h4 style="line-height: 20px;">发布商品</h4>
      </div>

    </li>

  </ul>

  <div class="card-body">
    <form action="{{ route('create_goods') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group " style="width:810px;">
        <label for="title" style="color: #969696;font-weight:bold">标题</label>
        <div class="row ml-0">
          <input type="" name="title" class="form-control" id="title" placeholder="显示在商品列表页..." style="width:405px;" value="{{ old('title') }}" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2"></div>
        </div>
      </div>

      <div class="form-group" style="width:750px;">
        <label for="description" style="color: #969696;font-weight:bold;">描述</label>
        <textarea class="form-control" id="description" rows="2" placeholder="显示在商品详情页..." name="description" style="height:52px;max-height: 126px;min-height: 52px;">{{ old('content') }}</textarea>
      </div>

      <div class="form-group">
        <label for="price" style="color: #969696;font-weight:bold;">标价</label>
        <div class="row ml-0">
          <input type="" name="price" class="form-control" id="price" placeholder="请填写数字价格，保留一位小数..." style="width:405px;" value="{{ old('price') }}" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2">填写范围为0~9999</div>
        </div>
      </div>
      <div class="form-group">
        <label for="old_price" style="color: #969696;font-weight:bold;">原价</label>
        <div class="row ml-0">
          <input type="" name="old_price" class="form-control" id="old_price" placeholder="请填写数字价格，保留一位小数..." style="width:405px;" value="{{ old('old_price') }}" required>
          <div style="line-height:35px;color:#636b6f" class="ml-2">填写范围为0~9999.9</div>
        </div>
      </div>

      <div class="form-group">
        <label for="u_phone" style="color: #969696;font-weight:bold;">分类</label>
        <select class="form-control" name="category_id" id="category" style="width:405px;">
          <option>学习</option>
          <option>生活</option>
          <option>娱乐</option>
          <option>其他</option>
        </select>
      </div>

      <div class="mt-3">
        <p style="color:#636b6f;font-size:17px">商品图片：<small>第一张默认为封面图片</small>
          <button type="button" id="add" class="btn btn-success ml-2" style="line-height:20px;width:90px;height:32px;">
            继续添加
          </button>
        </p>
      </div>
      <div class="form-group border " style="height:48px;width: 800px;border-radius:5px;">
        <input type="file"  name="goods_img[]" data-toggle="tooltip" data-placement="bottom" class="form-control-file  ml-2 " title="请上传 (png,jpg,gif,jpeg) 格式的图片" style="margin-top: 12px;" required />
      </div>

      <div class="more_image ">

        <!-- <div class="input-group mb-3 border img" style="width: 800px; border-radius:5px;">
          <input class="mt-2 ml-2" type="file" name="avatar" data-toggle="tooltip" data-placement="bottom" class="form-control-file  " title="请上传 (png,jpg,gif,jpeg) 格式的图片" style="margin-top:12px;width:745px;height:35px;" required />
          <div class="input-group-append">
            <button class="btn btn-outline-danger ml-1" type="button" id="button-addon2">
            <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                <path style="line-height:30px" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
            </svg>
            </button>
          </div>
        </div> -->

      </div>


      <div class="form-group form-check mb-2" style=" width:98px;right:20px">
        <button type="submit" class="btn btn-primary mt-4" style="line-height:20px;margin-right:10px;width:800px;height:32px">
          确认修改
        </button>
      </div>
    </form>
  </div>

</div>

<script src="/js/create_goods.js"></script>

@stop
