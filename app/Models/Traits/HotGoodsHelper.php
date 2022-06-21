<?php

namespace App\Models\Traits;

use App\Models\Good;
use App\Models\Comment;
use Carbon\Carbon;
use Arr;
use DB;
use Cache;


trait HotGoodsHelper
{

  // 基本信息
  protected $view_weight = 40; // 浏览量权重
  protected $comment_weight = 60; // 评论权重
  protected $capita_comment_max_number = 3;     // 人均评论数最大值
  protected $at_least_from_today = 1;    // 1天。发布时间需要大于1天
  protected $hot_goods_top = 10; // 需要热度Top几的商品

 protected $hot_goods_nearly_week=2;    // 近1周的商品
  // V-商品浏览量
  // T-商品发布时间距今的天数(近1周)，7 >= T >= 1
  // C-评论人数(不重复)，C <= V
  // N-评论数量
  // 40-浏览量的权重分
  // 60-评论量的权重分
  // 若 N<3C, 实际评论 < 最多评论数(最多人均评论数 * 评论人数)
  // (V/T) x 40+ (60 x C + 60/3C x N) 
  // 否则
  // (V/T) x 40+ (60 x C +60)

  // 
  //protected $goods = [];


  // 缓存配置
  protected $cache_key = 'onestore_hot_goods';
  protected $cache_expire_in_seconds = 60 * 60 ;   // 秒


  public function getHotGoods()
  {
    // remember-从缓存中取出 cache_key 对应的数据。若有，直接返回数据。
    // 否则通过匿名函数来取出热度商品数据，返回的同时做缓存。
    return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function () {
      return $this->calculateAndCacheHotGoods();
    });
  }

  public function calculateAndCacheHotGoods()
  {
    
    // 取得 热度商品数据
    $hot_goods = $this->calculateScore();

    //dd($hot_goods);
    // 并做缓存
    $this->cacheHotGoods($hot_goods);
    return $hot_goods;
  }

  // 计算 热度分值
  private function calculateScore()
  {
    
    $goods = Good::where('created_at', '>=', Carbon::now()->subWeeks($this->hot_goods_nearly_week))->whereNotIn('state',[Good::goods_state_in_release,Good::goods_state_in_check])
    ->with('comments')->get();    // 近1周
    //dd($goods[0]->comments);
    //dd(count($goods));
    $score_sort = [];   // 关联数组，记录得分

    for ($i = 0; $i < count($goods); $i++) {
      // T- 发布天数
      $diff_in_days = Carbon::parse($goods[$i]->created_at)->diffInDays(Carbon::now(), false);

      // 获取 评论人数 - C
      $users_id=[];   // 记录评论的用户
      for($j=0;$j<count($goods[$i]->comments);$j++){
        array_push($users_id,$goods[$i]->comments[$j]->user_id);    // 存放 每个商品的评论用户id
      }
      $comment_users=count(array_unique($users_id));   // 通过去重，得到不重复的评论人数
      //dd($comment_users);

      if ($diff_in_days >= $this->at_least_from_today) {
        $view_score = $this->view_weight * $goods[$i]->view_count / $diff_in_days;   // 浏览得分

        // C-评论人数
        // $comment_users = Comment::query()->select(DB::raw('user_id'))
        //   ->where('goods_id', '=', $goods[$i]->id)
        //   ->groupBy('user_id')
        //   ->get()->count();
        if ($comment_users > 0) {
          // 评论得分
          if ($goods[$i]->reply_count < $this->capita_comment_max_number * $comment_users) {
            $comment_score = $this->comment_weight * $comment_users + ($this->comment_weight / ($this->capita_comment_max_number * $comment_users) * $goods[$i]->reply_count);
          } else {
            $comment_score = $this->comment_weight * $comment_users + $this->comment_weight;
          }
        }
        $score_sort[$i] = round($view_score + $comment_score);   // 热度总分
      }
    }
    // 创建集合 - 存放热门商品
    $hot_goods = collect();

    $score_sort = array_reverse(Arr::sort($score_sort), true);   // 排序
    //dd($score_sort);
    $index = 0;
    foreach ($score_sort as $key => $value) {        // 按照排序 插入
      if ($index == $this->hot_goods_top) break;
      $hot_goods->push($goods[$key]);
      $index++;
    }

    return $hot_goods;    // 热度商品
  }

  private function cacheHotGoods($hot_goods)
  {
    //dd($hot_goods);
    // 将数据放入缓存
    Cache::put($this->cache_key, $hot_goods, $this->cache_expire_in_seconds);
    
  }
}
