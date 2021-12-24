<!-- 我的预订展示 -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;">
  <div class="card ">

    <div class="card-body">
      <div class="row ">
        <i class="far fa-envelope mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
        <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
          Sakura
          <span style="letter-spacing:2px">的预订</span>
          （{{ count($yes_reply_booking)+count($no_reply_booking) }}）
        </h1>
      </div>
    </div>
    <hr style="width: 650px;margin:0 auto;">
    <div class="card-body">
      <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">待回复</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">已回复</a>
        </li>
      </ul>

      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <ul class="list-group list-group-flush">
            @if( count($no_reply_booking) > 0 )
            @foreach ($no_reply_booking as $booking => $value)
            <li class="list-group-item">
              <div class="row no-gutters">

                <div class="">
                  <a href="">
                    <img src="{{ Str::before($value->goods->image,',') }}" style="width: 100px; height:100px;" alt="...">
                  </a>

                </div>
                <div class="ml-2" >
                  <div class="mt-4">
                    <a href="">
                      <img src="{{ $value->user->avatar }}" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                    </a>
                     <a href="">{{ $value->user->name }}</a>  未回复您的预订！
                  </div>


                  <div class="card-text mt-1 ml-3"><small title="{{ $value->created_at }}" class="text-muted">预订于 {{ $value->created_at->diffForHumans() }}</small></div>
                </div>
              </div>
            </li>
            @endforeach
            <div class="card-body">
              {!! $no_reply_booking->render() !!}
            </div>

            @else
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                暂无数据 ~_~
              </div>
            </div>
            @endif
          </ul>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <ul class="list-group list-group-flush">
            @if( count($yes_reply_booking) > 0 )
            @foreach ($yes_reply_booking as $booking => $value)
            <li class="list-group-item">
              <div class="row no-gutters">
                <div class="">
                  <a href="">
                    <img src="{{ Str::before($value->goods->image,',') }}" style="width: 100px; height:100px;" alt="...">
                  </a>
                </div>
                <div class="ml-2" >
                  <div class="mt-4">
                    <a href="">
                      <img src="/images/avatar.png" alt="" class="img-thumbnail img-responsive img-circle" width="45px" height="45px" style="border-radius: 50%;">
                    </a>
                    <a href="">{{ $value->user->name }}</a> <span style="color:{{ ($value->user_state=='1') ? 'green':'red'  }};">{{ ($value->user_state=='1') ? '同意':'拒绝' }}</span> 您的预订！
                  </div>
                  <div class="row">
                    <div class="card-text mt-1 ml-3"><small title="{{ $value->created_at }}" class="text-muted">预订于 {{ $value->created_at->diffForHumans() }}</small></div>
                    <div class="card-text mt-1 ml-3"><small title="{{ $value->updated_at }}" class="text-muted">回复于 {{ $value->updated_at->diffForHumans() }}</small></div>

                  </div>

                </div>
              </div>
            </li>
            @endforeach
            <div class="card-body">
              {!! $yes_reply_booking->render() !!}
            </div>

            @else
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                暂无数据 ~_~
              </div>
            </div>
            @endif
          </ul>

        </div>
      </div>
    </div>
  </div>



</div>
@stop
