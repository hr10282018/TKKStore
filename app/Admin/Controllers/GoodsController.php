<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\Check;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Good;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Str;
use App\Models\GoodTag;
use App\Models\Order;
use App\Notifications\CheckGoods;
use Encore\Admin\Layout\Content;


class GoodsController extends AdminController
{
  
  protected $title = '商品';

  protected function grid()
  {
    $grid = new Grid(new Good());

    // 搜索过滤器
    $grid->filter(function ($filter) {

      // 添加字段过滤器
      $filter->like('title', '商品标题');
      $filter->like('user_id', '所属用户 ID');
    });

    $grid->id('ID')->sortable();

    $grid->title('商品标题')->display(function ($value) {

      return Str::limit($value, 25, '. . .');
    })->filter('like');   //过滤-模糊查询

    //$grid->column('description', __('Description'));
    //$grid->column('image', __('Image'));

    // 商品标签
    $grid->tags('标签')->display(function ($value) {
      
      $tags=explode('-',$value);

      $tags_data = GoodTag::whereIn('id', $tags)->get();
      $tag_str = '';
      for ($i = 0; $i < sizeof($tags_data); $i++) {
        $tag_str .= '<span style="margin-right: 5px;padding: .5em .6em .5em;" class="label label-success">';
        $tag_str .= $tags_data[$i]['name'];
        $tag_str .= '</span>';
      }
      return $tag_str;
    });


    $grid->state('当前状态')->display(function ($value) {

      if ($value == Good::goods_state_in_release) {
        return '预发布';
      } elseif ($value == Good::goods_state_in_check) {
        return '待审核';
      } elseif ($value == Good::goods_state_in_selling) {
        return '出售中';
      } elseif ($value == Good::goods_state_in_booking) {
        return '预定中';
      } elseif ($value == Good::goods_state_in_sold) {
        return '已出售';
      }
    })->filter([      // 过滤 商品状态
      Good::goods_state_in_release => '预发布',
      Good::goods_state_in_check => '待审核',
      Good::goods_state_in_selling => '出售中',
      Good::goods_state_in_booking => '预定中',
      Good::goods_state_in_sold => '已出售',
    ]);

    $grid->price('标价')->filter('range');      // 价格-范围过滤

    //$grid->column('old_price', __('Old price'));

    //$grid->column('view_count', __('View count'));

    //$grid->column('reply_count', __('Reply count'));

    //$grid->column('category_id', __('Category id'));

    //$grid->column('user_id', __('User id'));

    // 商品创建的时间
    $grid->created_at('创建时间')->sortable();    // 排序

    //$grid->column('updated_at', __('Updated at'));

    $grid->disableCreateButton();   // 禁用 新增

    $grid->tools(function ($tools) {
      // 禁用批量删除按钮
      $tools->batch(function ($batch) {
        $batch->disableDelete();
      });
    });


    // 操作
    $grid->actions(function ($actions) {

      // 禁用 编辑
      $actions->disableEdit();

      // 状态为待审核-才添加审核操作
      if ($actions->row['state'] == Good::goods_state_in_check) {
        $actions->add(new Check);    // 自定义审核
      }
    });

    return $grid;
  }



  protected function detail($id)
  {
    $show = new Show(Good::findOrFail($id));

    
    $show->field('id', 'ID');

    $show->field('user_id', '所属用户 ID');

    $show->field('category_id', '类别')->as(function ($value) {
      $category = Category::where('id', $value)->first();
      return $category->name;
    });

    

    $show->field('title', '标题');

    $show->field('description', '描述');

    $show->tags('标签')->as(function($value){
      $tags=explode('-',$value);

      $tags_data = GoodTag::whereIn('id', $tags)->get();
      $tag_str = '';
      for ($i = 0; $i < sizeof($tags_data); $i++) {
        $tag_str .= '【';
        $tag_str .= $tags_data[$i]['name'];
        $tag_str .= '】  ';
      }
      
      return $tag_str;
    });

    $show->field('image', '图片')->carousel();

    $show->field('state', '状态')->as(function ($value) {

      if ($value == Good::goods_state_in_release) return '预发布';
      elseif ($value == Good::goods_state_in_check) return '待审核';
      elseif ($value == Good::goods_state_in_selling) return '出售中';
      elseif ($value == Good::goods_state_in_booking) return '预定中';
      elseif ($value == Good::goods_state_in_sold) return '已出售';
    });

    $show->field('price', '售价');

    $show->field('old_price', '原价');

    $show->field('view_count', '浏览量');

    $show->field('reply_count', '评论量');

    $show->field('created_at', '创建时间');

    $show->field('updated_at', '修改时间');

    $show->panel()->tools(function ($tools) use($show) {

      if($show->getModel()->toArray()['state'] != Good::goods_state_in_check){    // 非审核
        $tools->disableEdit();      // 审核
      }
      //$tools->disableList();
      // $tools->disableDelete();
    });

    return $show;
  }


  protected function form()
  {
    $form = new Form(new Good());

    $form->setTitle('审核');      // vendor/encore/laravel-admin/src/Admin.php


    $form->display('id', 'ID');


    $form->display('title', '标题');

    $form->textarea('description', '描述')->readonly();

    $form->multipleImage('image', '图片');


    // $form->display('category_id', '商品分类');

    // $form->display('user_id', '用户ID');

    // $form->display('tags', __('Tags'));

    $states = [
      'on'  => ['value' => Good::goods_state_in_selling, 'text' => '通过', 'color' => 'success'],
      'off' => ['value' => Good::goods_state_in_release, 'text' => '不通过', 'color' => 'danger'],
    ];
    $form->switch('check', '审核')->states($states);


    //$form->multipleSelect('null','选择原因')->options([1 => '商品信息不合格', 2 => '商品图片不合格',3=>'其他']);


    $form->checkbox('reason', '选择原因')->options([1 => Good::$checkReason[0], 2 => Good::$checkReason[1], 3 => Good::$checkReason[2]])->stacked();

    $form->textarea('other_reason', '其他原因')->rows(3);

    // $form->confirm('确定提交吗？');


    $form->tools(function (Form\Tools $tools) {

      // 去掉 `删除` 
      $tools->disableDelete();
    });


    $form->footer(function ($footer) {

      // 去掉`重置`按钮
      $footer->disableReset();

      // 去掉`查看`
      $footer->disableViewCheck();

      // 去掉`继续编辑`
      $footer->disableEditingCheck();

      // 去掉`继续创建`
      $footer->disableCreatingCheck();
    });

    return $form;
  }


  // 重写 edit 路由
  public function edit($id, Content $content)     //  vendor/encore/laravel-admin/src/Controllers/AdminController.php
  {
    //parent::edit($id, $content);

    // parent::edit($id, $content,$type);
    $good = new Good();
    $state = $good->goods_state_is_check($id);

    if (!$state) {
      // 路由-非待审核状态禁入
      return redirect()->back();
    }
    
    return $content
      ->title($this->title())
      ->description($this->description['edit'] ?? trans('admin.edit'))
      ->body($this->form()->edit($id));
  }

  /* 审核商品 */
  public function admin_check_goods(Request $request, Good $id)
  {
    $data = $request->all();

    $data = array_merge($data, ['goods_id' => $id->id, 'title' => $id->title]);

    if ($data['is_check'] == 'true') {     // 审核通过
      $id->update([
        'state'  => Good::goods_state_in_selling
      ]);

      // 消息通知
      $id->user->notify(new CheckGoods($id, $data));

      return [];
    } else {      // 审核不通过
      $reason = '';
      $id->update([
        'state'  => Good::goods_state_in_release
      ]);

      for ($i = 0; $i < count($data['reason']) - 1; $i++) {      // 循环 非其他原因
        if ($data['reason'][$i]) {

          if ($i == count($data['reason']) - 2)  $reason = $reason . Good::$checkReason[$i];
          else $reason = $reason . Good::$checkReason[$i] . '，';
        }
      }

      $data['reason'] = $reason;

      // 通知
      $id->user->notify(new CheckGoods($id, $data));
      return [];
    }
  }

  // 删除
  public function delete(Good $id){

    Good::find($id->id)->delete();

    return [];
  }
}
