<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\GoodInfoRequest;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\User;
use App\Policies\GoodPolicy;
use Auth;
use Carbon\Carbon;
use DB;
use App\Models\GoodTag;
use League\Flysystem\File;
use Illuminate\Support\Facades\URL;

class GoodsController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth', [   // 身份验证过滤动作
      //
      'except' => ['goods_search']
    ]);


  }

  /* 发布商品 */
  public function create_goods(GoodTag $good_tag)
  {
    $good_tag=GoodTag::get();
    //dd($good_tag);

    return view('goods.create_goods',compact('good_tag'));
  }
  // 处理发布商品数据
  public function create_goods_check(Request $request, Good $good, ImageUploadHandler $uploader)
  {

    //dd($request->all());

    // 最小宽和高316和418-最大宽和高480和500
    $goods = $request->all();
    $goods['image'] = '';
    for ($i = 0; $i < sizeof($goods['goods_img']); $i++) {
      // 暂时-宽度超过480，则等比缩放
      $true = $uploader->save($goods['goods_img'][$i], 'goods', Auth::user()->id,480,'width');
      if ($true) {
        $goods['image'] = $goods['image'] . $true['path'] . ',';
      } else {
        session()->flash('warning', '修改失败！请上传 PNG、GIF、JPG、JPEG 格式的图片');
        return redirect()->route('create_goods');
      }
    }

    $goods['user_id'] = Auth::user()->id;   // 用户id
    $goods['state'] = $request->goods_state;      // 1-商品发布且正在售卖
    $goods['category_id'] = Category::where('name', $goods['category_id'])->first()->id;  // 分类id

    $goods['tags']=$request->tag_data;     // 先测试标签1
    $good->fill($goods);
    $good->save();

    return redirect()->route('home')->with('success', '商品发布成功！');
  }

  // 测试-ajax验证商品数据
  // public function create_goods_check(GoodInfoRequest $request){


  //   return [];
  // }




  /* 商品查询 */
  public function goods_search(Request $request, Good $good, Category $category)
  {
    //dd($request->input('category_id', ''));
    $builder=Good::query();
    //dd($request->search);
    if ($category_id = $request->input('category_id', '')) {

      $categories = Category::where('id', $category_id)->first();
      $builder->where('category_id', $category_id);
    }
    if($key=$request->input('key', '')){    // 最新发布
      $builder ->where('created_at', '>=', Carbon::now()->subWeeks('4')); // 最近一个月
    }

    // if ($search = $request->input('search', '')) {
    //   dd($search);
    //   if($search != null){
    //     //dd($search);
    //     $like = '%' . $search . '%';
    //     $builder->where(function ($query) use ($like) {
    //       $query->where('title', 'like', $like)
    //             ->orWhere('description', 'like', $like);
    //     });
    //   }
    // }
    $search=$request->search;
    if($search != null){
      $like = '%' .$search. '%';
        $builder->where(function ($query) use ($like) {
          $query->where('title', 'like', $like)
                ->orWhere('description', 'like', $like);
        });
    }


    if ($state = $request->input('state', '')) {
      $builder->where('state', $state);
    }
    if ($order = $request->input('order', '')) {
      if($order=='1'){
         $builder->orderBy('price', 'asc');
      }elseif($order=='2'){
         $builder->orderBy('price', 'desc');
      }elseif($order=='3'){
         $builder->orderBy('created_at', 'asc');
      }else{
         $builder->orderBy('created_at', 'desc');
      }
    }

    $goods = $builder->paginate(16);
    if(isset($categories)){     // 有分类必须再返回分类数据
      return view('pages.root', compact('goods','categories','search','order','state'));
    }
    return view('pages.root', compact('goods','search','order','state'));
  }

  /* 商品详情 */
  public function goods_detail($goods_id, Request $request){

    if(!Auth::user()->activated){
      return redirect()->route('show_verify');
    }

    $goods_info=Good::where('id',$goods_id)->first();

    if(!$goods_info){
      // 定义出错页面
    }

     
    //dd($request);
  

    // 浏览量+1
    $old_view_count= $goods_info->view_count+1;
    $goods_info->update([
      'view_count'  => $old_view_count
    ]);

    $length=substr_count( $goods_info->image,',');
    $images=explode(',',$goods_info->image);
    $user=User::where('id',$goods_info->user_id)->first();
    
    // 取标签数据
    $tags=[];
    for($i=0; $i<strlen($goods_info->tags); $i++){
      if($goods_info->tags[$i] != '-'){
        array_push($tags,$goods_info->tags[$i]);
      }else{continue;}
    }
    //dd($tags);
    $tags_data=GoodTag::whereIn('id',$tags)->get();
    //dd($tags_data);

    $comments=Comment::where('goods_id',$goods_id)->orderBy('created_at', 'desc')->get();
    //$c_count=$comments->count();  // 商品评论
    //dd($comments);

    return view('goods.detail',compact('comments','tags_data'),compact('images','length','goods_info','user'));
  }

}
