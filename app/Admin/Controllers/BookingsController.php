<?php

namespace App\Admin\Controllers;

use App\Models\Booking;
use App\Models\Good;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BookingsController extends AdminController
{
  
  protected $title = '预定';

  protected function grid()
  {
    $grid = new Grid(new Booking());

    // 搜索过滤器
    $grid->filter(function ($filter) {

      // 添加字段过滤器
      $filter->like('booker_id', '预定用户 ID');
      
    });


    $grid->column('id', 'ID')->sortable();

    //$grid->column('goods_id','商品ID');

    $grid->column('booker_id',  ('预定用户 ID'))->sortable();

    $grid->column('user_state', ('用户状态'))->display(function($value){
      if($value == Booking::seller_refuse_booking){
        return '卖家拒绝';
      }elseif($value == Booking::seller_agree_booking){
        return '卖家同意';
      }elseif($value == Booking::seller_processing_booking){
        return '卖家未处理';
      }elseif($value == Booking::buyer_cancel_booking){
        return '买家取消';
      }

    })->filter([
      Booking::seller_refuse_booking => '卖家拒绝',
      Booking::seller_agree_booking => '卖家同意',
      Booking::seller_processing_booking => '卖家未处理',
      Booking::buyer_cancel_booking => '买家取消',
      
    ]);

    $grid->column('created_at', ('创建时间'))->sortable();
    
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
    $show = new Show(Booking::findOrFail($id));

    $show->field('id', 'ID');

    $show->field('goods_id', '商品 ID');

    $show->field('goods_state', '商品当前状态')->as(function($value) use($show){

      $state=$show->getModel()->goods->state;
     
      if ($state == Good::goods_state_in_release) {
        return '预发布';
      } elseif ($state == Good::goods_state_in_check) {
        return '待审核';
      } elseif ($state == Good::goods_state_in_selling) {
        return '出售中';
      } elseif ($state == Good::goods_state_in_booking) {
        return '预定中';
      } elseif ($state == Good::goods_state_in_sold) {
        return '已出售';
      }
      //if()
    });

    $show->field('user_id', '商品所属用户 ID');

    $show->field('booker_id', '预定用户 ID');

    $show->field('user_state', '用户状态')->as(function($value){
      if($value == Booking::seller_refuse_booking){
        return '卖家拒绝';
      }elseif($value == Booking::seller_agree_booking){
        return '卖家同意';
      }elseif($value == Booking::seller_processing_booking){
        return '卖家未处理';
      }elseif($value == Booking::buyer_cancel_booking){
        return '买家取消';
      }

    });
    

    if($show->getModel()->toArray()['user_state'] == Booking::seller_refuse_booking){
      
      $show->field('reason', '拒绝原因')->as(function($value){

        if($value == ''){
          return '无';
        }
        return $value;
      });
    }

    $show->field('created_at', '创建时间');

    $show->field('updated_at', '修改时间');

    $show->panel()->tools(function ($tools)  {

      $tools->disableEdit();      // 禁用 编辑
      //$tools->disableList();
      $tools->disableDelete();
    });

    return $show;
  }

 
  protected function form()
  {
    $form = new Form(new Booking());

    $form->number('goods_id', __('Goods id'));
    $form->number('user_id', __('User id'));
    $form->number('booker_id', __('Booker id'));
    $form->text('user_state', __('User state'));
    $form->text('reason', __('Reason'));

    return $form;
  }
}
