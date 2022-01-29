<!--  -->
@extends('layouts.app')

@section('title', isset($categories) ? $categories->name : '首页')

@section('content')

@if (isset($categories))
<div class="alert alert-info" role="alert">
  {{ $categories->name }} ：{{ $categories->description }}
</div>
@endif
<div class="card ml-4 " style="width: 1210px;margin-bottom:120px">
  <ul class="list-group list-group-flush">

    <li class="list-group-item">
      <div class="row ml-2 new_hot">
        <a style="border-radius: 0.25rem;" class="nav-link  mr-2 {{ active_class( if_query('key','new')) }}" href="{{ route('goods_search') }}?key=new&category_id={{ isset($categories) ? $categories->id : '' }}">最新发布</a>
        <a style="border-radius: 0.25rem;" class="nav-link  {{ active_class( if_query('key', 'hot')) }}" href="{{ route('goods_search') }}?key=hot">热门发布</a>

        <form id="search_form" method="GET" action="{{ route('goods_search') }}" class="form-inline " style="margin-left: 485px;">
          {{--@csrf--}}

          <input type="" name="category_id" value="{{ isset($categories) ? $categories->id : '' }}" hidden>
          <div class="input-group ">
            <div class="input-group-prepend">
              <button class="btn btn-outline-success" type="submit" id="button-addon1">Search</button>
            </div>
            <input type="text" name="search" value="{{  isset($search) ? $search : '' }}" class="form-control" placeholder="快来发现宝藏..." style="width: 200px;" aria-label="Example text with button addon" aria-describedby="button-addon1">

            <select class="custom-select" name="order" id="order_select" style="width: 105px; ">
              <option value="" selected>排序</option>
              <option value="1" {{ isset($order) && $order=='1' ? 'selected': '' }}>价格升序</option>
              <option value="2" {{ isset($order) && $order=='2' ? 'selected': '' }}>价格降序</option>
              <option value="3" {{ isset($order) && $order=='3' ? 'selected': '' }}>时间升序</option>
              <option value="4" {{ isset($order) && $order=='4' ? 'selected': '' }}>时间降序</option>
            </select>
            <select class="custom-select" name="state" id="state_select" style="width: 105px;">

              <option value="1" selected>正出售</option>
              <option value="2" {{ isset($state) && $state=='2' ? 'selected': '' }}>已预订</option>
              <option value="3" {{ isset($state) && $state=='3' ? 'selected': '' }}>已出售</option>
            </select>
          </div>
        </form>

      </div>
    </li>


    <li class="list-group-item">
      <div class="row ml-3 mt-2 " style="margin-bottom:20px">

        @if(count($goods) > 0)
        @foreach ($goods as $good => $value)

        <div class="card mr-3  mb-2 " id="goods_list" style="width: 270px;height:435px;">
          <a href="{{ route('goods_detail',$value->id) }}?from={{ isset($categories) ? $categories->id : 'all' }} ">
            <img style="width: 268px; height:270px" src="{{ Str::before($value->image,',') }}" class="card-img-top img-thumbnail" alt="...">
          </a>

          <div class="card-body" style="position:relative;padding-bottom:0px;">
            <h5 class="card-title" style="height:50px">
              {{ Str::limit($value->title,45,'...') }}
            </h5>
            <div class="row mt-3">
              <p class="card-text  ml-3" title="{{ $value->created_at }}" style="position:relative;color:#a5a5a5; font-size:12px">发布于 {{ $value->created_at->diffForHumans() }}</p>
              <p class="card-text ml-4 mr-1" style="position:relative;color:#a5a5a5; font-size:12px; left:0px">浏览量 {{$value->view_count}}</p>
            </div>
            <p class="card-text mt-2" style="color:#d73038; ">￥ {{ $value->price }}元</p>
          </div>
        </div>

        @endforeach

      </div>
    </li>

    <div class="card-body" style="margin:0 auto ;">
      <!-- {!! $goods->render() !!} -->
      {!! $goods->appends(Request::except('page'))->render() !!}
    </div>
  </ul>

  @else
  <div class="card-body">
    <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
      暂无该物品 ~_~
    </div>
  </div>
  @endif
</div>
</div>


@stop
