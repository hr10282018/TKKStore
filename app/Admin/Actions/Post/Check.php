<?php

namespace App\Admin\Actions\Post;

use App\Models\Good;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Check extends RowAction
{
  public $name = '审核';

  public function href()
  {

    $goods=Good::where('id', $this->getKey())->get();

    
    return "{$this->getResource()}/{$this->getKey()}/edit";
  }
}
