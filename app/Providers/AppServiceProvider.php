<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    // 开发环境加载-用户切换工具包
    if (app()->isLocal()) {   // isLocal(.env文件的APP_ENV=local)-是local则返回true，表示只在本地环境注册
      $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
    }
  }


  public function boot()
  {
    \App\Models\Booking::observe(\App\Observers\BookingObserver::class);  // 预定模型
  }
}
