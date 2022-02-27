<?php

namespace App\Admin\Controllers;

use App\Models\Good;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Str;
use App\Models\GoodTag;

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
      $filter->like('user_id', '所属用户ID');
    });


    $grid->id('ID')->sortable();

    $grid->title('商品标题')->display(function ($value) {

      return Str::limit($value, 25, '. . .');
    });

    //$grid->column('description', __('Description'));

    //$grid->column('image', __('Image'));


    // 商品标签
    $grid->tags('标签')->display(function ($value) {
      $tags = [];
      for ($i = 0; $i < strlen($value); $i++) {
        if ($value[$i] != '-') {
          array_push($tags, $value[$i]);
        } else {
          continue;
        }
      }
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
      // 0-未发布，1-发布且正在售卖，2-发布且被预订，3-发布且已出售
      if ($value == 0) {
        return '未发布';
      } elseif ($value == 1) {
        return '已发布';
      } elseif ($value == 2) {
        return '已预定';
      } elseif ($value == 3) {
        return '已出售';
      }
    });

    $grid->price('标价');

    //$grid->column('old_price', __('Old price'));

    //$grid->column('view_count', __('View count'));

    //$grid->column('reply_count', __('Reply count'));

    //$grid->column('category_id', __('Category id'));

    //$grid->column('user_id', __('User id'));

    // 商品创建的时间
    $grid->created_at('创建时间');


    //$grid->column('updated_at', __('Updated at'));




    $grid->tools(function ($tools) {
      // 禁用批量删除按钮
      $tools->batch(function ($batch) {
        $batch->disableDelete();
      });
    });

    return $grid;
  }

  /**
   * Make a show builder.
   *
   * @param mixed $id
   * @return Show
   */
  protected function detail($id)
  {
    $show = new Show(Good::findOrFail($id));

    $show->field('id', __('Id'));
    $show->field('title', __('Title'));
    $show->field('description', __('Description'));
    $show->field('image', __('Image'));
    $show->field('state', __('State'));
    $show->field('price', __('Price'));
    $show->field('old_price', __('Old price'));
    $show->field('view_count', __('View count'));
    $show->field('reply_count', __('Reply count'));
    $show->field('category_id', __('Category id'));
    $show->field('user_id', __('User id'));
    $show->field('created_at', __('Created at'));
    $show->field('updated_at', __('Updated at'));
    $show->field('tags', __('Tags'));

    return $show;
  }

  /**
   * Make a form builder.
   *
   * @return Form
   */
  protected function form()
  {
    $form = new Form(new Good());

    $form->text('title', __('Title'));
    $form->textarea('description', __('Description'));
    $form->textarea('image', __('Image'));
    $form->switch('state', __('State'));
    $form->decimal('price', __('Price'));
    $form->decimal('old_price', __('Old price'));
    $form->number('view_count', __('View count'));
    $form->number('reply_count', __('Reply count'));
    $form->number('category_id', __('Category id'));
    $form->number('user_id', __('User id'));
    $form->text('tags', __('Tags'));

    return $form;
  }
}
