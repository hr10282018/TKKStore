<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{

  protected $policies = [
    // 'App\Model' => 'App\Policies\ModelPolicy',
  ];

  public function boot()
  {
    $this->registerPolicies();
    // 修改策略自动发现的逻辑
    Gate::guessPolicyNamesUsing(function ($modelClass) {
      // 动态返回模型对应的策略名称，如：// 'App\Models\User' => 'App\Policies\UserPolicy',
      return 'App\Policies\\' . class_basename($modelClass) . 'Policy';
    });
  }
}
