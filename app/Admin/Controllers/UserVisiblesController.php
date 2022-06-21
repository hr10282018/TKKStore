<?php

namespace App\Admin\Controllers;

use App\Models\UserVisible;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserVisiblesController extends AdminController
{
 
  protected $title = '用户可见';

  
  protected function grid()
  {
    $grid = new Grid(new UserVisible());

    // 搜索过滤器
    $grid->filter(function ($filter) {

      // 添加字段过滤器
      $filter->like('user_id', '用户 ID');
      
    });

    $grid->column('id', 'ID')->sortable();

    $grid->column('user_id', '用户 ID')->sortable();

    $grid->column('v_email','邮箱可见')->display(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }      
    });

    $grid->column('v_phone', '手机号可见')->display(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }      
    });

    $grid->column('v_university', '大学可见')->display(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }      
    });

    $grid->column('v_faculty', '院系可见')->display(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }      
    });

    $grid->column('v_number','学号可见')->display(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }      
    });

    $grid->column('v_r_name', '真实姓名可见')->display(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }      
    });

    $grid->column('created_at', '创建时间')->sortable();

    //$grid->column('updated_at', '修改时间');
    // $grid->column('v_buy_booking_goods', __('V buy booking goods'));
    // $grid->column('v_buy_sale_goods', __('V buy sale goods'));
    // $grid->column('v_booking_goods', __('V booking goods'));
    // $grid->column('v_sale_goods', __('V sale goods'));
    // $grid->column('v_saled_goods', __('V saled goods'));
    // $grid->column('v_comment', __('V comment'));

    // 操作
    $grid->actions(function ($actions) {
      // 禁用 编辑
      $actions->disableEdit();
      $actions->disableDelete();
      
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
    $show = new Show(UserVisible::findOrFail($id));

    $show->field('id','ID');

    $show->field('user_id', '用户 ID');

    $show->field('v_email', '邮箱可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_phone', '手机号码')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_university', '大学可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_faculty', '院系可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_number', '学号可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_r_name', '真实姓名可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_buy_booking_goods', '订购商品-预定可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_buy_sale_goods', '订购商品-购买可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_booking_goods', '发布商品-预定中可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_sale_goods', '发布商品-出售中可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_saled_goods', '发布商品-已出售可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('v_comment','评论可见')->as(function($value){
      if($value){
        return '是';
      }else{
        return '否';
      }
    });

    $show->field('created_at','创建时间');

    $show->field('updated_at', '修改时间');

    $show->panel()->tools(function ($tools)  {

      $tools->disableEdit();      // 禁用 编辑
      //$tools->disableList();
      $tools->disableDelete();
    });

    return $show;
  }

  /**
   * Make a form builder.
   *
   * @return Form
   */
  protected function form()
  {
    $form = new Form(new UserVisible());

    $form->number('user_id', __('User id'));
    $form->switch('v_email', __('V email'))->default(1);
    $form->switch('v_phone', __('V phone'))->default(1);
    $form->switch('v_university', __('V university'))->default(1);
    $form->switch('v_faculty', __('V faculty'))->default(1);
    $form->switch('v_number', __('V number'))->default(1);
    $form->switch('v_r_name', __('V r name'))->default(1);
    $form->switch('v_buy_booking_goods', __('V buy booking goods'))->default(1);
    $form->switch('v_buy_sale_goods', __('V buy sale goods'))->default(1);
    $form->switch('v_booking_goods', __('V booking goods'))->default(1);
    $form->switch('v_sale_goods', __('V sale goods'))->default(1);
    $form->switch('v_saled_goods', __('V saled goods'))->default(1);
    $form->switch('v_comment', __('V comment'))->default(1);

    return $form;
  }
}
