<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{

  // 表示这个页面的标题
  protected $title = '用户';


  // grid() -来决定列表页要展示哪些列
  protected function grid()
  {
    $grid = new Grid(new User());


    // 搜索过滤器
    $grid->filter(function ($filter) {
      
      // 添加字段过滤器
      $filter->like('name', '用户名');
      $filter->like('email', 'QQ邮箱');


    });

    // 用户的 id 字段
    $grid->id('ID');

    // 用户的 name 字段。
    $grid->name('用户名');

    //$grid->column('r_name', __('R name')); 真实姓名

    // 用户的头像
    $grid->avatar('头像')->image(45,45);

    // 用户的 邮箱 字段。
    $grid->email('QQ邮箱');

    // 用户验证邮箱的时间判断-是否验证邮箱
    $grid->email_verified_at('邮箱验证')->display(function ($value) {
      return $value ? '是' : '否';
    });

    // 用户的注册时间
    $grid->created_at('注册时间');
    //$grid->column('updated_at', __('Updated at'));



    //$grid->column('signature', __('Signature'));  个性签名

    // 用户的性别
    $grid->sex('性别');

    //$grid->column('phone', __('Phone'));
    //$grid->column('university', __('University'));
    //$grid->column('faculty', __('Faculty'));
    //$grid->column('number', __('Number'));
    //$grid->column('activation_token', __('Activation token'));
    //$grid->column('activated', __('Activated'));

    $grid->tools(function ($tools) {
      // 禁用批量删除按钮
      $tools->batch(function ($batch) {
        $batch->disableDelete();
      });
    });

    return $grid;
  }


  // detail() -用来展示用户详情页，通过调用 detail() 方法来决定要展示哪些字段
  protected function detail($id)
  {
    $show = new Show(User::findOrFail($id));

    //$show->field('id', __('Id'));
    $show->id('ID');

    //$show->field('name', __('姓名'));
    $show->name('姓名');

    //$show->field('r_name', __('R name'));
    $show->r_name('真实姓名');

    //$show->field('email', __('Email'));
    $show->email('QQ邮箱');

    $show->field('email_verified_at', __('Email verified at'));


    //$show->field('password', __('Password'));
    //$show->field('remember_token', __('Remember token'));
    $show->field('created_at', __('Created at'));
    //$show->field('updated_at', __('Updated at'));
    $show->field('avatar', __('Avatar'));
    $show->field('signature', __('Signature'));
    $show->field('sex', __('Sex'));
    $show->field('phone', __('Phone'));
    $show->field('university', __('University'));
    $show->field('faculty', __('Faculty'));
    $show->field('number', __('Number'));
    //$show->field('activation_token', __('Activation token'));
    //$show->field('activated', __('Activated'));

    return $show;
  }


  // form()-用于编辑和创建用户
  protected function form()
  {
    $form = new Form(new User());

    $form->text('name', __('Name'));
    $form->text('r_name', __('R name'));
    $form->email('email', __('Email'));
    $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
    $form->password('password', __('Password'));
    $form->text('remember_token', __('Remember token'));
    $form->image('avatar', __('Avatar'));
    $form->text('signature', __('Signature'));
    $form->text('sex', __('Sex'));
    $form->mobile('phone', __('Phone'));
    $form->text('university', __('University'))->default('厦大嘉庚');
    $form->text('faculty', __('Faculty'));
    $form->text('number', __('Number'));
    $form->text('activation_token', __('Activation token'));
    $form->switch('activated', __('Activated'));

    return $form;
  }
}
