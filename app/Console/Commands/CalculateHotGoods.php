<?php

namespace App\Console\Commands;

use App\Models\Good;
use Illuminate\Console\Command;

class CalculateHotGoods extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'onestore:calculate-hot-goods';    // 调用命令

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '生成热度商品';     // 命令描述

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle(Good $goods)      // 执行的方法
  {
    // 命令行打印信息
    $this->info("开始计算...");

    $goods->calculateAndCacheHotGoods();

    $this->info("生成成功！");
  }
}
