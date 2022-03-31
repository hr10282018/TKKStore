<!-- 我的评论 -->
@extends('users.show')
@section('user_info')

<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 " style="margin-left: 60px;">
  <div class="card mb-5">
    <div class="card-body">
      <div class="row mt-2 ">
        <i class="fab fa-twitch mr-2 ml-3 mt-2" style="font-size: 26px;color:#636b6f"></i>
        <h1 class="ml-2 mt-2" style="line-height: 24px;color:#636b6f; font-size:20px;font-weight:bold; ">
          {{$user->name}}
          <span style="letter-spacing:2px"> 评论</span>
          （{{ $count }}）
        </h1>
      </div>
    </div>
    <hr style="width: 650px;margin:0 auto;">

    <div class="card-body">
      {{-- 评论 --}}
      <ul class="list-group list-group-flush">
        @if(!Auth::user()->can('update_user_info', $user) && !$user_visible->v_comment)
            <div class="card-body">
              <div class="" style="color:#ccc; text-align: center;line-height: 60px; margin: 10px;">
                限制访问 ~_~
              </div>
            </div>
        @else

          @if(count($comments) > 0)
          @foreach($comments as $comment => $value)
          <li class="list-group-item">
            <a href="{{ route('goods_detail',$value->goods->id)."?tab=comments#comment-$value->id" }}">{{ Str::limit($value->goods->title,35,'...')}} </a>
            <div>
              <span style="color: #6c757d ;"> {{ Str::limit($value->content,45,'...')}}</span>
            </div>

            <div id="time" class=" mt-2 row" style="color: rgb(99 ,107, 111);">
              <span class="ml-3" title="{{ $value->created_at }}">
                <i class="far fa-clock" style="font-size: 15px;"></i>
                <span class="ml-2" style="font-size: 12px;">评论于 {{$value->created_at->diffForHumans() }}</span>
              </span>
            </div>
          </li>
          @endforeach
          <li class="list-group-item">
            <div class="mt-2">
              {!! $comments->render() !!}
            </div>
          </li>

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
</div>
@stop