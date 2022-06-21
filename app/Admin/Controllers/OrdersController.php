<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Collection;
use PDO;

use function PHPUnit\Framework\returnSelf;

class OrdersController extends AdminController
{

  protected $title = '订单';

 

  protected function grid()
  {
    $grid = new Grid(new Order());

    // 搜索过滤器
    $grid->filter(function ($filter) {

      // 添加字段过滤器
      $filter->like('no', '订单号');
      $filter->like('goods_id', '商品 ID');
      
    });

    $grid->column('id', 'ID')->sortable();

    $grid->column('no', '订单号')->filter('like');

    $grid->column('goods_id', '商品 ID')->sortable();

    //$grid->column('user_id', );
    //$grid->column('buyer_id', __('Buyer id'));

    // $grid->column('buyer_state', '买家状态');

    $grid->column('order_state','当前订单状态')->display(function() {

      // 生效订单：1-2、1-4 (卖家状态 - 买家状态)
      $active_order_1=$this->seller_state == Order::seller_confirm_order && $this->buyer_state == Order::buyer_confirm_order;
      $active_order_2=$this->seller_state == Order::seller_confirm_order && $this->buyer_state == Order::buyer_outdate_order;
      if( $active_order_1 || $active_order_2 ){
        return '已生效';
      }
      
      // 未生效订单：2-3、1-3、2-1 
      $inactive_order_1= $this->seller_state == Order::seller_pending_order && $this->buyer_state == Order::buyer_pending_order;
      $inactive_order_2= $this->seller_state == Order::seller_confirm_order && $this->buyer_state == Order::buyer_pending_order;
      $inactive_order_3= $this->seller_state == Order::seller_pending_order && $this->buyer_state == Order::buyer_refuse_order;
      if( $inactive_order_1 || $inactive_order_2 || $inactive_order_3 ){
        return '未生效';
      }
      
      // 取消订单有：0-1、0-3、1-0
      $cancel_order_1= $this->seller_state == Order::seller_cancel_order && $this->buyer_state == Order::buyer_refuse_order;
      $cancel_order_2= $this->seller_state == Order::seller_cancel_order && $this->buyer_state == Order::buyer_pending_order;
      $cancel_order_3= $this->seller_state == Order::seller_confirm_order && $this->buyer_state == Order::buyer_cancel_order;
      if( $cancel_order_1 || $cancel_order_2 || $cancel_order_3 ){
        return '取消';
      }
 
    })->filter([
      '已生效'=>'已生效',
      '未生效'=>'未生效',
      '取消'=>'取消',
    ]);

    // $grid->column('reason', '原因');

    $grid->column('payment_amount', '支付金额')->sortable();

    $grid->column('payment_method', '支付方式')->display(function($value){
      if($value == Order::payment_wechat){
        return '微信';
      }elseif($value == Order::payment_alipay){
        return '支付宝';
      }elseif($value == Order::payment_cash){
        return '现金';
      }elseif($value == Order::payment_other){
        return '其他';
      }
    });

    //$grid->column('remark', __('Remark'));
    //$grid->column('is_delete', __('Is delete'));
    
    $grid->column('created_at', '创建时间')->sortable();

    //$grid->column('updated_at', __('Updated at'));

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
    $show = new Show(Order::findOrFail($id));

    $show->field('id', 'ID');

    $show->field('no', '订单号');

    $show->field('goods_id', '商品 ID');

    $show->field('user_id', '卖家用户 ID');

    $show->field('buyer_id', '买家用户 ID');

    $show->field('order_state','当前订单状态')->as(function($value){
      
      // 生效订单：1-2、1-4 (卖家状态 - 买家状态)
      $active_order_1=$this->seller_state == Order::seller_confirm_order && $this->buyer_state == Order::buyer_confirm_order;
      $active_order_2=$this->seller_state == Order::seller_confirm_order && $this->buyer_state == Order::buyer_outdate_order;
      if( $active_order_1 || $active_order_2 ){
        return '已生效';
      }
      
      // 未生效订单：2-3、1-3、2-1 
      $inactive_order_1= $this->seller_state == Order::seller_pending_order && $this->buyer_state == Order::buyer_pending_order;
      $inactive_order_2= $this->seller_state == Order::seller_confirm_order && $this->buyer_state == Order::buyer_pending_order;
      $inactive_order_3= $this->seller_state == Order::seller_pending_order && $this->buyer_state == Order::buyer_refuse_order;
      if( $inactive_order_1 || $inactive_order_2 || $inactive_order_3 ){
        return '未生效';
      }
      
      // 取消订单有：0-1、0-3、1-0
      $cancel_order_1= $this->seller_state == Order::seller_cancel_order && $this->buyer_state == Order::buyer_refuse_order;
      $cancel_order_2= $this->seller_state == Order::seller_cancel_order && $this->buyer_state == Order::buyer_pending_order;
      $cancel_order_3= $this->seller_state == Order::seller_confirm_order && $this->buyer_state == Order::buyer_cancel_order;
      if( $cancel_order_1 || $cancel_order_2 || $cancel_order_3 ){
        return '取消';
      }
    });
    
    $show->field('seller_state', '当前卖家状态')->as(function($value){
      if($value == Order::seller_cancel_order){
        return '取消订单';
      }else if($value == Order::seller_confirm_order){
        return '确认订单';
      }else if($value == Order::seller_pending_order){
        return '未处理订单';
      }
      
    });

    $show->field('buyer_state', '当前买家状态')->as(function($value){
      if($value == Order::buyer_cancel_order){
        return '取消订单';
      }elseif($value == Order::buyer_refuse_order){
        return '拒绝订单（订单信息有误）';
      }elseif($value == Order::buyer_confirm_order){
        return '同意订单';
      }elseif($value == Order::buyer_pending_order){
        return '未处理订单';
      }elseif($value == Order::buyer_outdate_order){
        return '订单回复超时（自动确认）';
      }
    });

    $show->field('reason', '买家拒绝订单原因')->as(function($value){
      if($value == '') return '无';
      return $value;
    });
    
    $show->field('payment_amount', '支付金额')->as(function($value){
      return $value . '（元）';
    });

    $show->field('payment_method', '支付方式')->as(function($value){
      if($value == Order::payment_wechat){
        return '微信';
      }elseif($value == Order::payment_alipay){
        return '支付宝';
      }elseif($value == Order::payment_cash){
        return '现金';
      }elseif($value == Order::payment_other){
        return '其他';
      }
    });
    
    $show->field('remark', '备注')->as(function($value){
      if($value == '') return '无';
      return $value;
    });

    $show->field('created_at', '创建时间');

    $show->field('updated_at', '修改时间');

    $show->field('is_delete', '软删')->as(function($value){
      if($value == Order::not_deleted){
        return '否';
      }elseif($value == Order::is_deleted){
        return '是';
      }
    });

    $show->panel()->tools(function ($tools)  {

      $tools->disableEdit();      // 禁用 编辑
      //$tools->disableList();
      $tools->disableDelete();
    });

    return $show;
  }

  
  protected function form()
  {
    $form = new Form(new Order());

    $form->text('no', __('No'));
    $form->number('goods_id', __('Goods id'));
    $form->number('user_id', __('User id'));
    $form->number('buyer_id', __('Buyer id'));
    $form->switch('seller_state', __('Seller state'));
    $form->switch('buyer_state', __('Buyer state'));
    $form->text('reason', __('Reason'));
    $form->decimal('payment_amount', __('Payment amount'));
    $form->switch('payment_method', __('Payment method'));
    $form->text('remark', __('Remark'));
    $form->switch('is_delete', __('Is delete'));

    return $form;
  }
}
