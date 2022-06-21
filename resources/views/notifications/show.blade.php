@extends('layouts.app')
@section('title', '消息通知')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-body">

        <h3 class="text-xs-center">
          <i class="far fa-bell" aria-hidden="true"></i> 
           消息通知 （{{ $count }}）
        </h3>
        <hr>

        
        <ul class="list-group list-group-flush">

          @if(count($notifications) > 0)
          @foreach($notifications as $notification=>$value)

          
            <!-- 判断消息类型 -->
            @if($value->type == 'App\Notifications\BookingGoods')       <!-- 预定通知 -->
              <li class="list-group-item">
                <a href="{{ route('user_show' , $value->data['booker_id']) }}" target="_blank">
                  <img src="{{ $value->data['booker_avatar'] }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                </a>
                <a href="{{ route('user_show' , $value->data['booker_id']) }}">{{ $value->data['booker_name'] }}</a> 预定了你的商品！
                <a href="{{ route('booking_notice', Auth::id()) }}?reply=no">点击查看</a>

                
                <div id="time" class="text-secondary mt-2 mr-1  row" style="float:right;display:flex;" >
                  <span class="ml-3" title="{{ $value->created_at }}">
                    <i class="far fa-clock" style="font-size: 15px;"></i>
                    <span class="ml-2" style="font-size: 12px;">预定于{{ $value->created_at->diffForHumans() }}</span>
                  </span>
                </div>
              </li>
            @elseif($value->type == 'App\Notifications\CheckGoods')       <!-- 审核通知 -->
              <li class="list-group-item">
                <span style="color: #6c757d; font-size:16px">你的商品</span> 
                <a href="{{ route('goods_detail' ,$value->data['goods_id']) }}" target="_blank">
                  {{ $value->data['title'] }}
                </a>
                <span style="font-size:16px;color: #6c757d;">审核</span>

                
                @if($value->data['is_check'] == 'true')
                  <span style="color:green;font-size:16px">【通过】</span>
                @else
                  <span style="color:#d73038;font-size:16px">【不通过】</span>
                  <span style="font-size:16px;color: #6c757d;">，原因：</span> 
                  <span style="color:#d73038">{{ $value->data['reason'] }}</span>
                  
                  @if( $value->data['other_reason'] != null)
                  <span style="font-size:16px;color: #6c757d;">，其他原因：</span> 
                  <span style="color:#d73038">{{ $value->data['other_reason'] }}</span>
                  @endif

                @endif
                <div id="time" class="text-secondary  mr-1  row" style="float:right;display:flex;" >
                  <span class="ml-3" title="{{ $value->created_at }}">
                    <i class="far fa-clock" style="font-size: 15px;"></i>
                    <span class="ml-2" style="font-size: 12px;">审核于{{ $value->created_at->diffForHumans() }}</span>
                  </span>
                </div>
              </li>
            @elseif($value->type == 'App\Notifications\CancelOrders')
              <li class="list-group-item">
                @if( $value->data['seller_state'] == 0)      {{-- 卖家取消 --}}
                  
                  @if( $value->notifiable_id == $value->data['buyer_id'])
                    卖家
                    <a href="{{ route('user_show' , $value->data['seller_id']) }}" target="_blank">
                      <img src="{{ $value->data['seller_avatar'] }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                    </a>
                    <a href="{{ route('user_show' , $value->data['seller_id']) }}">
                      {{ $value->data['seller_name'] }}
                    </a>
                    
                    <span style="color: red; ">取消</span> 订单。
                    订单号：{{ $value->data['no'] }}

                    订单商品：
                    <a href="{{ route('goods_detail' ,$value->data['order_goods_id']) }}" target="_blank">
                      {{ $value->data['order_goods_title'] }}
                    </a>
                  @elseif( $value->notifiable_id == $value->data['seller_id'])
                    你
                    <span style="color: red; ">取消</span>订单。
                    
                    订单号：{{ $value->data['no'] }}。
                    订单商品：
                    <a href="{{ route('goods_detail' ,$value->data['order_goods_id']) }}" target="_blank">
                      {{ $value->data['order_goods_title'] }}
                    </a>
                   
                  @endif

                @else   {{-- 买家取消 --}}
                  @if(Auth::user()->id == $value->data['buyer_id'])
                    你
                    <span style="color:red; ">取消</span> 订单。
                    订单号：{{ $value->data['no'] }}

                    订单商品：
                    <a href="{{ route('goods_detail' ,$value->data['order_goods_id']) }}" target="_blank">
                      {{ $value->data['order_goods_title'] }}
                    </a>
                  @elseif(Auth::user()->id == $value->data['seller_id'] )
                    买家
                    <a href="{{ route('user_show' , $value->data['buyer_id']) }}" target="_blank">
                      <img src="{{ $value->data['buyer_avatar'] }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                    </a>
                    <a href="{{ route('user_show' , $value->data['seller_id']) }}">
                      {{ $value->data['buyer_name'] }}
                    </a>

                    <span style="color: red;">取消</span>  订单。
                   
                    订单号：{{ $value->data['no'] }}
                    订单商品：
                    <a href="{{ route('goods_detail' ,$value->data['order_goods_id']) }}" target="_blank">
                      {{ $value->data['order_goods_title'] }}
                    </a>
                  @endif

                @endif
                <div id="time" class="text-secondary  mr-1  row" style="float:right;display:flex;" >
                  <span class="ml-3" title="{{ $value->created_at }}">
                    <i class="far fa-clock" style="font-size: 15px;"></i>
                    <span class="ml-2" style="font-size: 12px;">取消于{{ $value->created_at->diffForHumans() }}</span>
                  </span>
                </div>
              </li>

            @endif
          @endforeach
          <li class="list-group-item">
            <div class="mt-2">
              {!! $notifications->render() !!}
            </div>
          </li>

          @else
          <div class="empty-block">没有消息通知！</div>
          @endif

        </ul>
      </div>
    </div>
  </div>
</div>



@stop