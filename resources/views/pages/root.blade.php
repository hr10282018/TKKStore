<!--  -->
@extends('layouts.app')

@section('title', isset($categories) ? $categories->name : '首页')

@section('content')

@if (isset($categories))
<div class="alert alert-info" role="alert">
  {{ $categories->name }} ：{{ $categories->description }}
</div>
@endif
<div class="card ml-4 " style="width: 1230px;margin-bottom:120px; ">
  <ul class="list-group list-group-flush card_box">
    <!--这里设为动态高度-->

    <li class="list-group-item ">
      <div class="row ml-2 new_hot">

        <a id="new_goods" style="border-radius: 0.25rem;"  class="nav-link new {{ active_class( if_query('key','new')) }}" href="{{ route('goods_search') }}?key=new&time=3&category_id={{ isset($categories) ? $categories->id : '' }}">
          最新发布
        </a>

        <div class="dropdown-menu" id="new_goods_time" style="top:80%">
          <div class="form-check form-check-inline ">
            <input id="three_day" autocomplete="off" class="form-check-input" time="3" type="radio" name="inlineRadioOptions" value="{{ route('goods_search') }}?key=new&time=3&category_id={{ isset($categories) ? $categories->id : '' }}" {{ new_goods_times(3) }}>
            <label id="three_label" class="form-check-label" for="three_day">3天</label>
            
          </div>
          <div class="form-check form-check-inline">
            <input autocomplete="off" class="form-check-input" type="radio" time="7" name="inlineRadioOptions" id="seven_day" value="{{ route('goods_search') }}?key=new&time=7&category_id={{ isset($categories) ? $categories->id : '' }}" {{ new_goods_times(7) }}>
            <label class="form-check-label" for="seven_day">7天</label>
          </div>
          <div class="form-check form-check-inline">
            <input autocomplete="off" class="form-check-input" type="radio" time="15" name="inlineRadioOptions" id="fifteen_day" value="{{ route('goods_search') }}?key=new&time=15&category_id={{ isset($categories) ? $categories->id : '' }}" {{ new_goods_times(15) }}>
            <label class="form-check-label" for="fifteen_day">15天</label>
          </div>
        </div>
      
        

        <a style="border-radius: 0.25rem;" class="nav-link hot {{ active_class(if_route('goods_hot')) }}" href="{{ route('goods_hot') }}">
          热门发布 
        </a>

        @if(!isset($hot_goods))
        <form id="search_form" method="GET" action="{{ route('goods_search') }}" class="form-inline " style="margin-left: 485px;">
          {{--@csrf--}}

          <input type="" name="category_id" value="{{ isset($categories) ? $categories->id : '' }}" hidden>
          <input type="" class="btn_new_hot" name="key" value="" hidden>
          <input type="" class="btn_new_time" name="time" value="" hidden>

          <div class="input-group ">
            <div class="input-group-prepend">
              <button class="btn btn-outline-success btn_search" type="button" id="button-addon1">Search</button>
            </div>
            <input type="text" name="search" value="{{  isset($search) ? $search : '' }}" class="form-control" placeholder="快来发现宝藏..." style="width: 200px;" aria-label="Example text with button addon" aria-describedby="button-addon1" >

            <select class="custom-select" name="order" id="order_select" style="width: 105px; ">
              <option value="1" selected>时间降序</option>
              <option value="2" {{ isset($order) && $order=='2' ? 'selected': '' }}>时间升序</option>
              <option value="3" {{ isset($order) && $order=='3' ? 'selected': '' }}>价格升序</option>
              <option value="4" {{ isset($order) && $order=='4' ? 'selected': '' }}>价格降序</option>
              <!-- <option value="4" {{ isset($order) && $order=='4' ? 'selected': '' }}>时间降序</option> -->
            </select>
            <select class="custom-select" name="state" id="state_select" style="width: 105px;">

              <option value="2" selected>出售中</option>
              <option value="3" {{ isset($state) && $state=='3' ? 'selected': '' }}>预定中</option>
              <option value="4" {{ isset($state) && $state=='4' ? 'selected': '' }}>已出售</option>
            </select>
          </div>
        </form>
        @endif
      </div>
    </li>

    <div class="row ml-3 mt-4 card_div" style="height:auto">
      @if(isset($hot_goods))
        @if(count($hot_goods) > 0)
        <?php $index=1; ?>
        @foreach ($hot_goods as $value)
        <div class="card mr-4  mb-3 goods_list" id="goods_list" style="width: 270px; overflow: hidden;">

          <a href="{{ route('goods_detail',$value->id) }}?from={{ isset($categories) ? $categories->id : 'all' }} ">
            <img style="width: 268px; " src="{{ $value->image[0] }}" class="card-img-top  goods_img" alt="...">
          </a>

          <div class="card-body " id="" style="position:relative;padding-bottom:0px; margin-bottom:30px">
            <span id="" class="card-title card_title" style="height:35px;font-size:110%;letter-spacing: 0.5px;">
              {{ Str::limit($value->title,25,'...') }}
            </span>

            <div class="card-text mt-2 time card_time" id="" title="{{ $value->created_at }}" style="position:relative; font-size:12px">
              <i class="far fa-clock"></i> <span class="ml-1">发布于 {{ $value->created_at->diffForHumans() }} </span>
            </div>

            <div class="row mt-1 card_vr" id="" style="height:20px">
              <p class="card-text ml-3 mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px">
                <i class="far fa-eye"></i> <span class="ml-1">{{$value->view_count}}</span>
              </p>
              <p class="card-text ml-5 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;">
                <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->reply_count}}</span>
              </p>

              <p class="card-text ml-4 mt-1 mr-1 reply" style="position:relative; font-size:15px; left:0px;">
              @if($index == 1)
                <i class="fab fa-hotjar" style="width: 25px;height:25px;display:flex;color:#d73038;margin:0 auto"> <span class="ml-1">【1】</span></i>
              @elseif($index== 2)
              <i class="fab fa-hotjar" style="width: 25px;height:25px;display:flex;color:#ff5c38;margin:0 auto"> <span class="ml-1">【2】</span></i>
              @elseif($index== 3)
              <i class="fab fa-hotjar" style="width: 25px;height:25px;display:flex;color:#ffb821;margin:0 auto"> <span class="ml-1">【3】</span></i>
              @else
              <i class="fab fa-hotjar" style="width: 25px;height:25px;display:flex;color:#7f7f8c;margin:0 auto"> <span class="ml-1">【{{$index}}】</span></i>
              @endif
              </p>
              <?php $index++; ?>
            </div>

            <p class="card-text mt-2 card_price" id="" style="color:#d73038; ">￥ {{ $value->price }}元</p>
          </div>
        </div>
        @endforeach
        @else
        <div class="card-body">
          <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
            暂无物品 ~_~
          </div>
        </div>
        @endif

      @else
      @if(count($goods) > 0)
      @foreach ($goods as $good => $value)

      <div class="card mr-4  mb-3 goods_list" id="goods_list" style="width: 270px; overflow: hidden;">
        <a href="{{ route('goods_detail',$value->id) }}?from={{ isset($categories) ? $categories->id : 'all' }} ">
          <img style="width: 268px; " src="{{ $value->image[0] }}" class="card-img-top  goods_img" alt="...">
        </a>

        <div class="card-body " id="" style="position:relative;padding-bottom:0px; margin-bottom:30px">
          <span id="" class="card-title card_title" style="height:35px;font-size:110%;letter-spacing: 0.5px;">
            {{ Str::limit($value->title,25,'...') }}
          </span>

          <div class="card-text mt-2 time card_time" id="" title="{{ $value->created_at }}" style="position:relative; font-size:12px">
            <i class="far fa-clock"></i> <span class="ml-1">发布于 {{ $value->created_at->diffForHumans() }} </span>
          </div>

          <div class="row mt-1 card_vr" id="" style="height:20px">
            <p class="card-text ml-3 mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px">
              <i class="far fa-eye"></i> <span class="ml-1">{{$value->view_count}}</span>
            </p>
            <p class="card-text ml-5 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;">
              <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->reply_count}}</span>
            </p>
          </div>

          <p class="card-text mt-2 card_price" id="" style="color:#d73038; ">￥ {{ $value->price }}元</p>
        </div>
      </div>
      @endforeach
    </div>

    <li class="list-group-item " style="top:10px"></li>
    <div class="card-body" style="margin:0 auto;margin-bottom:50px; position:relative; top:25px">
      <!-- {!! $goods->render() !!} -->
      {!! $goods->appends(Request::except('page'))->render() !!}
    </div>
  </ul>

    @else
    <div class="card-body">
      <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
        暂无物品 ~_~
      </div>
    </div>
    @endif
    @endif
  </div>
  </div>
@stop

@section('scriptsAfterJs')
<script>
  $(document).ready(function() {

    // 搜索
    $('.btn_search').click(function(){
      if($('.new').hasClass('active')){
        //console.log('最新')
        $('.btn_new_hot').val('new')
      }else if($('.hot').hasClass('active')){
        //console.log('最热')
        $('.btn_new_hot').val('hot')
      }
      $('#search_form').submit();
    })

    // 排序方式-自动提交表单
    $('#order_select').change(function() {
      if($('.new').hasClass('active')){
        $('.btn_new_hot').val('new')
      }else if($('.hot').hasClass('active')){
        $('.btn_new_hot').val('hot')
      }
      $('#search_form').submit();
    })

    // 商品状态
    $('#state_select').change(function() {
      if($('.new').hasClass('active')){
        $('.btn_new_hot').val('new')
      }else if($('.hot').hasClass('active')){
        $('.btn_new_hot').val('hot')
      }
      $('#search_form').submit();
    })

    // 瀑布流布局
    var max_height = [0] // 记录每行最大高度，4个
    var max_last = 0 // 记录最后一行最大卡片高度
    var cards = [] // 记录所有卡片高度，12个
    //var tops = [] // 记录后8个卡片top的值
    var card_length = $('.goods_list').length
    //console.log(card_length)
    $.each($('.goods_list'), function(index, value) {
      //console.log(index)
      var img_height = $('.goods_img').get(index).height // 图片高度
      var d_height = 150 // 底部高度
      var card_height = img_height + d_height // 卡片高度

      $('.goods_list').eq(index).css({
        'height': card_height,
      })

      cards[index] = card_height
      if (max_height[0] < cards[index]) {
        max_height[0] = cards[index]
      }
      if (index == card_length - 1) {

        if (card_length <= 4 && card_length > 0) {
          // 计算最后一行max高度
          for (var i = 0; i < card_length; i++) {
            if (max_last < $('.goods_list').eq(i).position().top + cards[i]) {
              max_last = $('.goods_list').eq(i).position().top + cards[i]
            }
          }
        }
        if (card_length <= 8 && card_length > 4) { // 一页只有两行商品
          for (var i = 4; i < card_length; i++) {
            
            $('.goods_list').eq(i).css({
            
              "top": ($('.goods_list').eq(i - 4).position().top + cards[i - 4] + 30) - $('.goods_list').eq(i).position().top
            })
          }
          // 计算最后一行max高度
          for (var i = 4; i < card_length; i++) {
            if (max_last < $('.goods_list').eq(i).position().top + cards[i]) {
              max_last = $('.goods_list').eq(i).position().top + cards[i]
            }
          }
        }

        if (card_length <= 12 && card_length > 8) { // 一页只有三行商品
          for (var i = 4; i < card_length; i++) {
            $('.goods_list').eq(i).css({
              "top": ($('.goods_list').eq(i - 4).position().top + cards[i - 4] + 30) - $('.goods_list').eq(i).position().top
            })
          }

          for (var i = 8; i < card_length; i++) {
            if (max_last < $('.goods_list').eq(i).position().top + cards[i]) {
              max_last = $('.goods_list').eq(i).position().top + cards[i]
            }
          }
        }
        if (card_length <= 16 && card_length > 12) { // 一页有四行商品
          //console.log('四行')
          //console.log(cards)
          //console.log($('.goods_list').eq(4).position().top)
          for (var i = 4; i < card_length; i++) {
            $('.goods_list').eq(i).css({
              "top": ($('.goods_list').eq(i - 4).position().top + cards[i - 4] + 30) - $('.goods_list').eq(i).position().top
            })
          }
          for (var i = 12; i < card_length; i++) {
            if (max_last < $('.goods_list').eq(i).position().top + cards[i]) {
              max_last = $('.goods_list').eq(i).position().top + cards[i]
            }
          }
        }
        $('.card_div').css("height", max_last - 55)
      }

    })


    // 最新发布 - 时间样式
    var this_btn
    $('#new_goods').click(function(e){
      if($(this).hasClass('active')){
        if($('#new_goods_time').is(':hidden')){
          $('#new_goods_time').show()
          this_btn = $(this)
        }else{
          $('#new_goods_time').hide()
          this_btn=null
        }
        return false;
      }
    })
    $('#new_goods_time').click(function(e){
      e.stopPropagation();
    })
    $(document).click(function() { //document-关闭时间菜单
      if (this_btn) {
        this_btn.trigger('click')
      }
      this_btn = null
    })
    // 选择时间
    $three=$('#three_day').val()
    $seven=$('#seven_day').val()
    $fifteen=$('#fifteen_day').val()
    
    //btn_new_time
    $('#new_goods_time input:radio:checked').each(function(){
      $('.btn_new_time').val($(this).attr('time'))
     
    })

    $('#three_day').click(function(){
      window.location.href= $three
    })
    $('#three_label').click(function(){
      window.location.href=$three
    })
    $('#seven_day').click(function(){
      window.location.href=$seven
    })
    $('#seven_label').click(function(){
      window.location.href=$seven
    })
    $('#fifteen_day').click(function(){
      window.location.href=$fifteen
    })
    $('#fifteen_label').click(function(){
      window.location.href=$fifteen
    })


  })
</script>
@stop
