<!-- 出售订单  -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;margin-bottom:75px">
  <div class="card ">
    <div class="card-body">
      <div class="row ">
        <i class="far fa-envelope mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
        <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
          {{ $user->name }}
          <span style="letter-spacing:2px"> 出售订单</span>
          @if(!Auth::user()->can('update_user_info', $user))
          （*）
          @else
          （{{ count($user->sellerOrders) }}）
          @endif
        </h1>
      </div>

      <form class="form-inline mt-2 ml-2" method="get" action="{{ route('search_seller_order',$user->id)}}">
        <input class="form-control mr-sm-2" name="content" type="search" placeholder="输入订单号..." aria-label="Search" style="width: 300px;">
        <input type="text"  name="type" value="{{$type}}" hidden>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜索</button>
      </form>

    </div>

    <hr style="width: 650px;margin:0 auto;">

    <div class="card-body ">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item pending" role="presentation">
          <a class="nav-link @if(seller_orders_active('pending')) active @endif" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="@if(seller_orders_active('pending')) true @else false @endif">
            待处理
            @if(seller_orders_active('pending'))
              @if(!Auth::user()->can('update_user_info', $user))
              【*】
              @else
              【{{ $pending_orders_count }}】
              @endif
            @endif
          </a>
        </li>
        <li class="nav-item processed" role="presentation">
          <a class="nav-link @if(seller_orders_active('processed')) active @endif" id="processed-tab" data-toggle="tab" href="#processed" role="tab" aria-controls="processed" aria-selected="@if(seller_orders_active('processed')) true @else false @endif">
          已处理
          @if(seller_orders_active('processed'))
            @if(!Auth::user()->can('update_user_info', $user))
              【*】
            @else
              【{{ $processed_orders_count }}】
            @endif
          @endif
          </a>
        </li>
      </ul>

      <input type="text" value="{{ $pending_orders_count/5 }}" name="" id="pending_orders_count" hidden>   <!-- 待回复页数 -->
      <input type="text" value="{{ $processed_orders_count/5 }}" name="" id="processed_orders_count" hidden>   <!-- 已回复页数-->

      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade @if(seller_orders_active('pending')) show active @endif" id="pending" role="tabpanel" aria-labelledby="pending-tab">
          <ul class="list-group list-group-flush">
            @if(!Auth::user()->can('update_user_info', $user))
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                限制访问 ~_~
              </div>
            </div>
            @else
              @if( count($pending_orders) > 0 )
              @foreach ($pending_orders as $orders => $value)
              <div class="accordion" id="accordionExample">

                <div class="card">
                  <div class="card-header" id="heading{{ $value->id }}">
                    <h2 class="mb-0">
                      <button class="btn  btn-block text-left " type="button" data-toggle="collapse" data-target="#collapse{{ $value->id }}" aria-expanded="false" aria-controls="collapse{{ $value->id }}">
                        <span class="" style="float:left;">订单号：{{ $value->no }} </span> 
                        <span class="" style="float:right">{{ $value->created_at }}</span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapse{{ $value->id }}" class="collapse " aria-labelledby="heading{{ $value->id }}" data-parent="#accordionExample" >
                    
                    <div class="card-body row" style="display: flex;align-items:center;padding:9px">
                      <div class="goods_title ml-3" style="">
                        <span style="margin:0 auto">商品信息</span> 
                      </div>
                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>
                      <div class="ml-1">  
                        <a href="{{ route('goods_detail',$value->goods->id ) }}" target="_blank">
                          <img src="{{ $value->goods->image[0] }}" style="width: 100px; height:100px;" alt="...">
                        </a>
                      </div>
                      <div class="ml-4">
                        <h5 class="card-title">
                          <a href="{{ route('goods_detail', $value->goods->id) }}" style="" target="_blank">{{ Str::limit($value->goods->title,30,'...')}}</a>
                        </h5>
                        <div class="mt-3">
                          <span class="" style="color: #d73038;height:25px;margin-bottom:0" title="售价">
                            ￥{{ $value->goods->price }}元
                          </span>
                          <span class="ml-4">
                            <small title="{{ $value->goods->created_at }}" class="text-muted">发布于
                              {{$value->goods->created_at->diffForHumans() }}</small>
                          </span>
                        </div>

                        <div class="mt-1">
                          <!-- 浏览量 + 评论量 -->
                          <span class="card-text  mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px" title="浏览量">
                            <i class="far fa-eye"></i> <span class="ml-1">{{$value->goods->view_count}}</span>
                          </span>
                          <span class="card-text ml-2 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;" title="评论量">
                            <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->goods->reply_count}}</span>
                          </span>
                        </div>
                      </div>
                    </div>

                    <hr class="" style="width: 530px;margin:0 auto;">

                    <div class="card-body row" style="display: flex;align-items:center;padding:9px">
                      <div class="buyer_title ml-3" style="width:56px">
                        <span style="margin:0 auto">用户信息</span> 
                      </div>
                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>

                      <div class="ml-1" >
                        <div class="seller " >
                          <span class="mr-2" style="color: #636b6f;">卖家</span>
                          <a href="{{ route('user_show' , $value->user->id) }}" target="_blank">
                            <img src="{{ $value->user->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                          </a>
                          <a href="{{ route('user_show' , $value->user->id) }}" target="_blank">{{ $value->user->name }}</a>
                          @if($value->user->sex == '男')
                            <img src="/images/iconfont/boy.png" title="男" class="mr-2" alt="" style="width: 23px;height:23px;margin-left:3px">
                          @else
                            <img src="/images/iconfont/girl.png" title="女" class="mr-2" alt="" style="width: 23px;height:23px;margin-left:3px">
                          @endif
                        </div>
                        <div class="buyer">
                          <span class="mr-2" style="color: #636b6f;">买家</span> 
                          <a href="{{ route('user_show' , $value->buyer->id) }}">
                            <img src="{{ $value->buyer->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                          </a>
                          <a href="{{ route('user_show' , $value->buyer->id) }}">{{ $value->buyer->name }}</a> 
                          @if($value->buyer->sex == '男')
                            <img src="/images/iconfont/boy.png" title="男" class="mr-2" alt="" style="width: 23px;height:23px;margin-left:3px">
                          @else
                            <img src="/images/iconfont/girl.png" title="女" class="mr-2" alt="" style="width: 23px;height:23px;margin-left:3px">
                          @endif
                        </div>
                      </div>
                    </div>
                    <hr class="" style="width: 530px;margin:0 auto;">

                    <div  class="card-body row" style="display: flex;align-items:center; padding:9px">
                      
                      <div class="buyer_title ml-3" style=" width:56px">
                        <span style="margin:0 auto">支付信息</span> 
                      </div>
                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>
                      
                      <div class="ml-1">
                        <div class="mb-1" >
                          <label for="amount" style="color: #636b6f;">金额</label>
                          
                          <input type="text" autocomplete="off" value="{{ $value->goods->price }}" class="form-control ml-2" id="amount" style="width:171px;display:inline" >
                          <span class="ml-2" style="color:#636b6f;font-size:12px">填写范围为 0.1 ~ 9999.9，最多保留一位小数</span>
                          <div class="wrong_tip_price ml-5" style="font-size: 11px;"></div>
                        </div>
                        <div class="mt-2">
                          <label for="method" style="color: #636b6f;">方式</label>
                          <select class="form-control ml-2" id="method" style="width:171px;display:inline " autocomplete="off">
                            <option value="0" @if($value->payment_method == 0) selected @endif>微信</option>
                            <option value="1" @if($value->payment_method == 1) selected @endif>支付宝</option>
                            <option value="2" @if($value->payment_method == 2) selected @endif>现金</option>
                            <option value="3" @if($value->payment_method == 3) selected @endif>其他</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <hr class="" style="width: 530px;margin:0 auto;">

                    <div  class="card-body row" style="display: flex;align-items:center; padding:7px">
                      <div class="buyer_title ml-3" style=" width:56px">
                        <span style="margin:0 auto">订单状态</span>
                      </div>

                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>
                      <div class="ml-2" style="width: 480px;">
                          @if(seller_order_pending($value->seller_state,$value->buyer_state)[0])
                            <div>
                              <span style="color: #38c172;font-size:16px;letter-spacing:1px">
                                订单已生效
                              </span>
                              <!-- <span style="color: #636b6f; font-size:13px;letter-spacing:0.7px">
                                (&lowast;buyer_order_processed($value->seller_state,$value->buyer_state)[1])
                              </span> -->
                            </div>
                            <div class="mt-2">
                              <span style="color:#636b6f;font-weight:600;font-size:14px;letter-spacing:0.7px">
                                【注】{{ seller_order_pending($value->seller_state,$value->buyer_state)[2] }}
                              </span>
                            </div>
                          @else
                            <div>
                              <span style="color: #d73038;font-size:16px;letter-spacing:1px">
                                订单未生效
                              </span>
                              <span style="color: #636b6f; font-size:13px;letter-spacing:0.7px">
                                (&lowast;{{ seller_order_pending($value->seller_state,$value->buyer_state)[1] }})
                              </span>
                            </div>
                            <div class="mt-2">
                              <span style="color:#636b6f;font-weight:600;font-size:14px;letter-spacing:0.7px">
                                【注】{{ seller_order_pending($value->seller_state,$value->buyer_state)[2] }}
                              </span>
                            </div>
                          @endif

                      </div>
                    </div>
                    <hr class="" style="width: 530px;margin:0 auto;">

                    @if($value->buyer_state == 1) 
                      <div  class="card-body row" style=" padding:7px;display: flex;align-items:center;">
                        <div class="buyer_title ml-3" style=" width:56px;">
                            <span style="margin:0 auto;color:#856404">拒绝原因</span>
                        </div>
                        <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>
                        <div class="card-text ml-2" style="width:350px">
                          <span style="font-size:15px;letter-spacing:0.7px">{{ $value->reason }}</span>
                        </div>
                        
                      </div>
                      <hr class="" style="width: 530px;margin:0 auto;">
                    @endif

                    <div  class="card-body row" style="display: flex;align-items:center; padding:7px">
                      <div class="buyer_title ml-3" style=" width:56px">
                        <span style="margin:0 auto">订单备注</span>
                      </div>

                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>
                      <div class="mb-1">
                        <textarea autocomplete="off" class="form-control" id="remark" rows="2" placeholder="备注..." name="remark" style="width:400px;height:48px;max-height: 95px;min-height: 48px;"></textarea>
                      
                      </div>
                    </div>
                    <hr class="" style="width: 530px;margin:0 auto;">
                    @if(seller_order_pending($value->seller_state,$value->buyer_state)[3])
                    <div  class="card-body row" style="display: flex;align-items:center; padding:5px">
                      <div class="card-body mt-2">
                        <button type="button" data-id="{{ $value->id }}" class="btn btn-sm btn-outline-danger ml-1 btn_cancel" style="width: 95px; height:33px;">取消订单</button>
                        
                        <button type="button" data-id="{{ $value->id }}" buyer-state="{{ $value->buyer_state }}" class="btn btn-sm btn-outline-success ml-4 btn_send" style="width: 95px; height:33px;">
                        @if($value->buyer_state == 1) 
                          确认修改
                        @elseif($value->buyer_state == 3)
                          确认发送
                        </button>
                        @endif
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>

              @endforeach
              <div class="card-body">
                {!! $pending_orders->appends(Request::except('page'))->render() !!}
              </div>

              @else
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  暂无数据 ~_~
                </div>
              </div>
              @endif
            @endif
          </ul>
        </div>

        <!-- 已处理 -->
        <div class="tab-pane fade @if(seller_orders_active('processed')) show active @endif" id="processed" role="tabpanel" aria-labelledby="processed-tab">
        <ul class="list-group list-group-flush">
            @if(!Auth::user()->can('update_user_info', $user))
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                限制访问 ~_~
              </div>
            </div>
            @else
              @if( count($processed_orders) > 0 )
              @foreach ($processed_orders as $orders => $value)
              <div class="accordion" id="accordionExample">

                <div class="card">
                  <div class="card-header" id="heading{{ $value->id }}">
                    <h2 class="mb-0">
                      <button class="btn  btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $value->id }}" aria-expanded="false" aria-controls="collapse{{ $value->id }}">
                        <span class="" style="float:left;">订单号：{{ $value->no }}</span> 
                        <span class="" style="float:right">{{ $value->created_at }}</span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapse{{ $value->id }}" class="collapse" aria-labelledby="heading{{ $value->id }}" data-parent="#accordionExample" >
                    
                    <div class="card-body row" style="display: flex;align-items:center;padding:9px">
                      <div class="goods_title ml-3" style="">
                        <span style="margin:0 auto">商品信息</span> 
                      </div>
                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>
                      <div class="ml-1">  
                        <a href="{{ route('goods_detail',$value->goods->id ) }}" target="_blank">
                          <img src="{{ $value->goods->image[0] }}" style="width: 100px; height:100px;" alt="...">
                        </a>
                      </div>
                      <div class="ml-4">
                        <h5 class="card-title">
                          <a href="{{ route('goods_detail', $value->goods->id) }}" style="" target="_blank">{{ Str::limit($value->goods->title,30,'...')}}</a>
                        </h5>
                        <div class="mt-3">
                          <span class="" style="color: #d73038;height:25px;margin-bottom:0" title="售价">
                            ￥{{ $value->goods->price }}元
                          </span>
                          <span class="ml-4">
                            <small title="{{ $value->goods->created_at }}" class="text-muted">发布于
                              {{$value->goods->created_at->diffForHumans() }}</small>
                          </span>
                        </div>

                        <div class="mt-1">
                          <!-- 浏览量 + 评论量 -->
                          <span class="card-text  mt-1 mr-1 eye" style="position:relative; font-size:12px; left:0px" title="浏览量">
                            <i class="far fa-eye"></i> <span class="ml-1">{{$value->goods->view_count}}</span>
                          </span>
                          <span class="card-text ml-2 mt-1 mr-1 reply" style="position:relative; font-size:12px; left:0px;" title="评论量">
                            <i class="far fa-comment-dots"></i> <span class="ml-1">{{$value->goods->reply_count}}</span>
                          </span>
                        </div>
                      </div>
                    </div>

                    <hr class="" style="width: 530px;margin:0 auto;">

                    <div class="card-body row" style="display: flex;align-items:center;padding:9px">
                      <div class="buyer_title ml-3" style="width:56px">
                        <span style="margin:0 auto">用户信息</span> 
                      </div>
                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>

                      <div class="ml-1" >
                        <div class="seller " >
                          <span class="mr-2" style="color: #636b6f;">卖家</span>
                          <a href="{{ route('user_show' , $value->user->id) }}" target="_blank">
                            <img src="{{ $value->user->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                          </a>
                          <a href="{{ route('user_show' , $value->user->id) }}" target="_blank">{{ $value->user->name }}</a>
                          @if($value->user->sex == '男')
                            <img src="/images/iconfont/boy.png" title="男" class="mr-2" alt="" style="width: 23px;height:23px;margin-left:3px">
                          @else
                            <img src="/images/iconfont/girl.png" title="女" class="mr-2" alt="" style="width: 23px;height:23px;margin-left:3px">
                          @endif
                        </div>
                        <div class="buyer">
                          <span class="mr-2" style="color: #636b6f;">买家</span> 
                          <a href="{{ route('user_show' , $value->buyer->id) }}">
                            <img src="{{ $value->buyer->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                          </a>
                          <a href="{{ route('user_show' , $value->buyer->id) }}">{{ $value->buyer->name }}</a> 
                          @if($value->buyer->sex == '男')
                            <img src="/images/iconfont/boy.png" title="男" class="mr-2" alt="" style="width: 23px;height:23px;margin-left:3px">
                          @else
                            <img src="/images/iconfont/girl.png" title="女" class="mr-2" alt="" style="width: 23px;height:23px;margin-left:3px">
                          @endif
                        </div>
                      </div>
                    </div>
                    <hr class="" style="width: 530px;margin:0 auto;">

                    <div  class="card-body row" style="display: flex;align-items:center; padding:9px">
                      
                      <div class="buyer_title ml-3" style=" width:56px">
                        <span style="margin:0 auto">支付信息</span> 
                      </div>
                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>
                      
                      <div class="ml-1">
                        <div class="mb-1" >
                          <label for="amount" style="color: #636b6f;">金额</label>
                          
                          <input type="text" autocomplete="off" value="{{ $value->goods->price }}" class="form-control ml-2" id="amount" style="width:171px;display:inline" disabled>
                          <!-- <span class="ml-2" style="color:#636b6f;font-size:12px">填写范围为 0.1 ~ 9999.9，最多保留一位小数</span> -->
                          <!-- <div class="wrong_tip_price ml-5" style="font-size: 11px;"></div> -->
                        </div>
                        <div class="mt-2">
                          <label for="method" style="color: #636b6f;">方式</label>
                          <select class="form-control ml-2" id="method" style="width:171px;display:inline " autocomplete="off" disabled>
                            <option value="0" @if($value->payment_method == 0) selected @endif>微信</option>
                            <option value="1" @if($value->payment_method == 1) selected @endif>支付宝</option>
                            <option value="2" @if($value->payment_method == 2) selected @endif>现金</option>
                            <option value="3" @if($value->payment_method == 3) selected @endif>其他</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <hr class="" style="width: 530px;margin:0 auto;">

                    <div  class="card-body row" style="display: flex;align-items:center; padding:7px">
                      <div class="buyer_title ml-3" style=" width:56px">
                        <span style="margin:0 auto">订单状态</span>
                      </div>

                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>
                      <div class="ml-2" style="width: 400px;">
                          @if(seller_order_processed($value->seller_state,$value->buyer_state)[0])
                            <div>
                              <span style="color: #38c172;font-size:16px;letter-spacing:1px">
                                订单已生效
                              </span>
                              <!-- <span style="color: #636b6f; font-size:13px;letter-spacing:0.7px">
                                (&lowast;buyer_order_processed($value->seller_state,$value->buyer_state)[1])
                              </span> -->
                            </div>
                            <div class="mt-2">
                              <span style="color:#636b6f;font-weight:600;font-size:14px;letter-spacing:0.7px">
                                【注】{{ seller_order_processed($value->seller_state,$value->buyer_state)[2] }}
                              </span>
                            </div>
                          @else
                            <div>
                              <span style="color: #d73038;font-size:16px;letter-spacing:1px">
                                订单未生效
                              </span>
                              <span style="color: #636b6f; font-size:13px;letter-spacing:0.7px">
                                (&lowast;{{ seller_order_processed($value->seller_state,$value->buyer_state)[1] }})
                              </span>
                            </div>
                            <div class="mt-2">
                              <span style="color:#636b6f;font-weight:600;font-size:14px;letter-spacing:0.7px">
                                【注】{{ seller_order_processed($value->seller_state,$value->buyer_state)[2] }}
                              </span>
                            </div>
                          @endif

                      </div>
                    </div>
                    <hr class="" style="width: 530px;margin:0 auto;">

                    <div  class="card-body row" style="display: flex;align-items:center; padding:7px">
                      <div class="buyer_title ml-3" style=" width:56px">
                        <span style="margin:0 auto">订单备注</span>
                      </div>

                      <div class="ml-2 mr-2" style="width: 2px;height:100px;background-color:#eee"></div>
                      <div class="mb-1">
                        <textarea autocomplete="off" class="form-control" id="remark" rows="2" placeholder="备注..." name="remark" style="width:400px;height:48px;max-height: 95px;min-height: 48px;" disabled>{{$value->remark}}</textarea>
                      
                      </div>
                    </div>
                    <hr class="" style="width: 530px;margin:0 auto;">
                    @if(seller_order_processed($value->seller_state,$value->buyer_state)[3])
                    <div  class="card-body row" style="display: flex;align-items:center; padding:5px">
                      <div class="card-body mt-2">
                        <button type="button" data-id="{{ $value->id }}" class="btn btn-sm btn-outline-danger ml-1 btn_cancel" style="width: 95px; height:33px;">取消订单</button>
                        
                        <button type="button" data-id="{{ $value->id }}" buyer-state="{{ $value->buyer_state }}" class="btn btn-sm btn-outline-success ml-4 btn_send" style="width: 95px; height:33px;">
                        @if($value->buyer_state == 1) 
                          确认修改
                        @elseif($value->buyer_state == 3)
                          确认发送
                        </button>
                        @endif
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>

              @endforeach
              <div class="card-body">
                {!! $processed_orders->appends(Request::except('page'))->render() !!}
              </div>

              @else
              <div class="card-body">
                <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                  暂无数据 ~_~
                </div>
              </div>
              @endif
            @endif
          </ul>
        </div>

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
    // $('#sandbox-container .input-group.date').datepicker({
    //   language: 'zh-CN'
    // })

    function reg_price() {
      var price = $("#amount").val();
      if(price==undefined) return false   // 没有该元素
      //console.log()
      var d_reg = /^0{1}\.{1}[1-9]{1}$/; // 小数-首位可以0，小数位不为0
      var d_reg2 = /^[1-9]{1}\d{0,3}\.{1}\d{1}$/; //  小数-首位不能0，小数位可为0
      var int_reg = /^[1-9]{1}\d{0,5}$/; // 整数-首位不能0

      if (price.length != 0) {
        if (d_reg.test(price) || d_reg2.test(price) || int_reg.test(price)) { // 原价格式正确
          $("#amount").addClass('is-valid').removeClass('is-invalid');
          $(".wrong_tip_price").addClass('valid-feedback').removeClass('invalid-feedback');
          $(".wrong_tip_price").html('');
        } else {
          $("#amount").addClass('is-invalid').removeClass('is-valid');
          $(".wrong_tip_price").addClass('invalid-feedback').removeClass('valid-feedback');
          $(".wrong_tip_price").html('<strong>格式错误，请重新填写！!</strong>');
        }
      } else {

        $("#amount").addClass('is-invalid').removeClass('is-valid');
        $(".wrong_tip_price").addClass('invalid-feedback').removeClass('valid-feedback');
        $(".wrong_tip_price").html('<strong>订单价格不能为空！!</strong>');
      }
    }
    
    // 验证售价字段
    if(window.location.href.indexOf('type=pending') != -1){
      reg_price()
    }
    
    $('#amount').blur(function() {
      reg_price()
    })
    
    
    // 确认发送
    buyer_state= $('.btn_send').attr('buyer-state')  // 获取买家状态
    $('.btn_send').click(function(){
      reg_price()
      if ($('.is-invalid').length != 0) {
        swal({
          text: '有错误选项，无法提交！',
          icon: 'error'
        })
      }else{
        //console.log('提交')
        swal({
          title: '你确认发送吗?',
          text: " ",
          icon: 'info',
          buttons: ['取消', '确认'],
        }).then((res)=>{
          if(!res) return
          var data={
            payment_amount: $('#amount').val(),
            payment_method:$('#method').val(),
            remark:$('#remark').val()
          }

          if(buyer_state == 1){     // 买家拒绝，再次发送修改
            data['buyer_state']=buyer_state
          }else if(buyer_state == 3){     // 卖家未发送，第一次发送
            data['buyer_state']=buyer_state
          }
         
          order_id=$('.btn_send').data('id')    // 订单id
          
          // 发送
          axios.post('/seller_send_order/'+order_id,data).then(function(res){
            console.log(res.data)
            swal({
              title: '发送成功！',
              icon: 'success',
              //buttons: ,
            }).then((res)=>{
              location.reload()
            })
          },function(error){
            console.log(error)
            if( error.response && error.response.status === 401 ){
              swal({
                title: '确认发送失败！',
                text: error.response.data.message,
                icon: 'error',
              }).then((res)=>{
                window.location.reload()
              })
            }

          })
        })
        $('.swal-text').addClass('warning_text')

        if(buyer_state == 1){
          $('.swal-text').html('修改的订单将发送给买家核对！').css({
            'letter-spacing':'0.7px',
          })
        }else if(buyer_state == 3){
          $('.swal-text').html('发送订单给买家核对！').css({
            'letter-spacing':'0.7px',
          })
        }
      }

    })

    // 取消订单
    $('.btn_cancel').click(function(){

      swal({
        title: '你确认取消吗?',
        text: " ",
        icon: 'info',
        buttons: ['考虑一下', '确认'],
      }).then((res)=>{
        if (!res) return

        order_id=$('.btn_cancel').data('id')
        axios.post('/seller_cancel_order/'+order_id).then((res)=>{
          console.log(res.data)
          swal({
            title:'取消成功!',
            //html:'',
            icon:'success'
          }).then((res)=>{
            location.reload()
          })
        },function(error){
          //console.log(error)
          if( error.response && error.response.status === 401 ){
            swal({
              title: '取消订单失败！',
              text: error.response.data.message,
              icon: 'error',
            }).then((res)=>{
              window.location.reload()
            })
          }
        })

      })
      $('.swal-text').addClass('warning_text')
      $('.swal-text').html('将会取消本次商品交易！').css({
        'letter-spacing':'0.7px',
      })
    })


    // page缓存
    var old_tail_url=[]   // 记录之前状态 -页数 
    var lastPage=Math.ceil($('#pending_orders_count').val())  // 获取 待回复最后一页
    var lastPage_yesReply=Math.ceil($('#processed_orders_count').val())  // 获取 已回复最后一页
    
    if (lastPage==0) lastPage=1
    if (lastPage_yesReply==0) lastPage_yesReply=1

    var now_url_page=window.location.href.split('page=')[1]    // 获取当前页
    if(now_url_page == undefined) now_url_page=1

    //console.log('已回复页数：'+lastPage_yesReply)
    //console.log('当前页数：'+now_url_page)

    //console.log(document.referrer.length);
    if(document.referrer.indexOf('seller_order') == -1 && document.referrer.length != 0){       // 当跳转不存在页数，referrer为空,此时也为刷新
      old_tail_url=['type=pending','type=processed']
      //console.log('跳转')
      $.removeCookie('pending_old_url')
      $.removeCookie('processed_old_url')

    }else if(document.referrer.indexOf('seller_order') ){       
      //console.log('刷新')
      if(!$.cookie('pending_old_url')){
        pending='type=pending'
       
      }else{
        if(window.location.href.indexOf('type=pending') != -1){   // 当前页面是待回复页面，则需要判断以下-page问题
          // 判断 待回复页数是否为0，且url为待回复
          if(now_url_page > lastPage){  //      最后一页问题-如果取消预定一个商品刚好没有下一页，而用户点了下一页，则改页数据为空，需返回第1页
            $.removeCookie('pending_old_url')
            pending='type=pending'
           
          }else if(now_url_page <= lastPage){
            
            pending=$.cookie('pending_old_url')
            //console.log(no_reply)
          }
        }else{        // 不是则不考虑
          pending=$.cookie('pending_old_url')
        }
      }

      if(!$.cookie('processed_old_url')){
        processed='type=processed'
      }else{
        if(window.location.href.indexOf('type=processed') != -1){   // 当前页面是已回复页面，则需要判断以下-page问题
          // 判断 已回复页数是否为0，且url为待回复
          if(now_url_page > lastPage_yesReply){  //      最后一页问题-如果取消预定一个商品刚好没有下一页，而用户点了下一页，则改页数据为空，需返回第1页
            $.removeCookie('processed_old_url')
            processed='type=processed'
            
          }else if(now_url_page <= lastPage_yesReply){
            
            processed=$.cookie('processed_old_url')
          }
        }else{        // 不是则不考虑
          processed=$.cookie('processed_old_url')
        }
      }
      
      //console.log(no_reply)
      old_tail_url=[pending,processed]
      // console.log(old_tail_url)
    }

     //console.log(old_tail_url)

    // 待处理 -点击
    $('.pending').click(function(){
      now_url=window.location.href

      index=now_url.indexOf("type")
      head=now_url.substring(0,index)

      //console.log(head+old_tail_url[0])
      window.location.href=head+old_tail_url[0]
    })

    // 已处理
    $('.processed').click(function(){
      now_url=window.location.href

      index=now_url.indexOf("type")
      head=now_url.substring(0,index)
      //console.log(head+old_tail_url[1])
      window.location.href=head+old_tail_url[1]
     
    })

    // 页数跳转-点击
    $('a.page-link').click(function(){
      next_url=$(this).attr('href')
      index=next_url.indexOf("type")
      tail=next_url.substring(index)
      //var reply_expire= new Date();
      //reply_expire.setTime(expiresDate.getTime() + (60*1000));   // 2小时

      if(window.location.href.indexOf("type=pending") != -1){   // 当前为-待回复页
        $.cookie('pending_old_url', tail);
      }else if((window.location.href.indexOf("type=processed") != -1)){
        $.cookie('processed_old_url', tail)
      }
    })


})
</script>

@stop