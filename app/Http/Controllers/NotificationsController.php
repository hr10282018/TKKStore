<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationsController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');    // 登录用户访问
  }


  public function notifications()
  {


    $notifications = Auth::user()->notifications();

    $count=$notifications->count();

    $notifications=$notifications->paginate(5);
    
    Auth::user()->ClearRead();   // 未读数量清零

    return view('notifications.show',compact('notifications','count'));
  }
}
