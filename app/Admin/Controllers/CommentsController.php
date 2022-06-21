<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;


class CommentsController extends AdminController
{

  protected $title = '评论';


  protected function grid()
  {
    $grid = new Grid(new Comment());

    $grid->column('id', 'ID')->width(100)->sortable();

    // 搜索过滤器
    $grid->filter(function ($filter) {

      // 添加字段过滤器
      $filter->like('content', '内容');
      $filter->like('user_id', '所属用户 ID');
    });

    // $grid->column('goods_id', __('Goods id'));
    // $grid->column('user_id', __('User id'));

    $grid->column('content', '内容')->display(function($value){

      return \Str::limit($value,30,'...');
    })->filter('like');;

    
    $grid->column('created_at', '创建时间')->sortable();

    //$grid->column('updated_at', __('Updated at'));

    // 操作
    $grid->actions(function ($actions) {
      // 禁用 编辑
      $actions->disableEdit();
      
    });

    $grid->disableCreateButton();   // 禁用 新增

    $grid->tools(function ($tools) {
      // 禁用 批量删除
      $tools->batch(function ($batch) {
        $batch->disableDelete();
      });

    });
    return $grid;
  }

 
  protected function detail($id)
  {
    $show = new Show(Comment::findOrFail($id));

    $show->field('id', 'ID');
    $show->field('goods_id', '商品 ID');
    $show->field('user_id', '评论用户 ID');
    $show->field('content', '内容');
    $show->field('created_at', '创建时间');
    $show->field('updated_at', '修改时间');

    $show->panel()->tools(function ($tools)  {

      $tools->disableEdit();      // 禁用 编辑
      //$tools->disableList();
      //$tools->disableDelete();
    });

    return $show;
  }

 
  protected function form()
  {
    $form = new Form(new Comment());

    $form->number('goods_id', __('Goods id'));
    $form->number('user_id', __('User id'));
    $form->textarea('content', __('Content'));

    return $form;
  }


  public function delete(Comment $id){
    
    $id->delete();

    return [];
  }
}
