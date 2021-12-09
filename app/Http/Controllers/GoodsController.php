<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoodsController extends Controller
{



  /* 发布商品 */
  public function create_goods(){
    return view('goods.create_goods');
  }

}
