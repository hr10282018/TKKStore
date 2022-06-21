<?php

namespace App\Admin\Controllers;

use App\Http\Requests\Request;
use App\Models\GoodTag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use DB;

class GoodTagsController extends AdminController
{

  protected $title = '商品标签';

  
  protected function grid()
  {
    $grid = new Grid(new GoodTag());

     // 搜索过滤器
     $grid->filter(function ($filter) {

      // 添加字段过滤器
      $filter->like('name', '名称');
    });

    $grid->column('id', 'ID')->sortable();

    $grid->column('name', '商品名称')->filter();

    $grid->column('created_at','创建时间')->sortable();

    //$grid->column('updated_at', __('Updated at'));

    return $grid;
  }

  protected function detail($id)
  {
    $show = new Show(GoodTag::findOrFail($id));

    $show->field('id', 'ID');

    $show->field('name', '名称');

    $show->field('created_at', '创建时间');

    $show->field('updated_at', '修改时间');

    return $show;
  }

  
  protected function form()
  {
    $form = new Form(new GoodTag());

    $form->display('id', 'ID');
    $form->text('name', '名称');

    $form->tools(function (Form\Tools $tools) {

      // 去掉 `删除` 
      $tools->disableDelete();
    });

    $form->footer(function ($footer) {

      // 去掉`重置`按钮
      //$footer->disableReset();

      // 去掉`提交`按钮
      // $footer->disableSubmit();

      // 去掉`查看`checkbox
       $footer->disableViewCheck();

      // 去掉`继续编辑`checkbox
      $footer->disableEditingCheck();

      // 去掉`继续创建`checkbox
       $footer->disableCreatingCheck();
    });

    return $form;
  }


  public function edit($id, Content $content)
  {
    
    return $content
      ->title($this->title())
      ->description($this->description['edit'] ?? trans('admin.edit'))
      ->body($this->form()->edit($id));
  }

  // 新增
  public function admin_create_good_tags(GoodTag $goodTag,Request $request){
    $data=$request->all();

    $goodTag->fill($data);
    $goodTag->save();
   
    return [];
  }

  public function delete(GoodTag $id){

    $id->delete();

    return [];
  }

  public function admin_edit_good_tags(GoodTag $id,Request $request){
    $data=$request->all();

    $id->update($data);
    return [];
  }
  
}
