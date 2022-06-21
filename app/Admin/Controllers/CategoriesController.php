<?php

namespace App\Admin\Controllers;

use App\Http\Requests\Request;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Str;
use Encore\Admin\Layout\Content;
use DB;

class CategoriesController extends AdminController
{
  protected $title = '商品分类';

  protected function grid()
  {
    $grid = new Grid(new Category());

    // 搜索过滤器
    $grid->filter(function ($filter) {

      // 添加字段过滤器
      $filter->like('name', '名称');
      $filter->like('description', '描述');
      
    });

    $grid->column('id', 'ID')->sortable();

    $grid->column('name', '名称')->filter();

    $grid->column('description', '描述')->display(function ($value) {
      return Str::limit($value, 20, '. . .');
    })->filter();

    $grid->column('created_at', '创建时间')->sortable();

    // 操作
    $grid->actions(function ($actions) {
      // 禁用 
      // $actions->disableEdit();
      $actions->disableDelete();
    });

    // $grid->disableCreateButton();   // 禁用 新增

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
    $show = new Show(Category::findOrFail($id));

    $show->field('id', 'ID');
    $show->field('name', '名称');
    $show->field('description', '描述');

    $show->field('created_at', '创建时间');
    $show->field('updated_at', '修改时间');

    $show->panel()->tools(function ($tools) {

      // 禁用
      //$tools->disableEdit();      
      //$tools->disableList();
      $tools->disableDelete();
    });
    return $show;
  }


  protected function form()
  {
    $form = new Form(new Category());

    $form->display('id', 'ID');
    $form->text('name', '名称');

    $form->textarea('description', '描述');

    $form->tools(function (Form\Tools $tools) {

      // 去掉`删除`
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

  // 删除
  // public function delete(Good $id){

  //   Good::find($id->id)->delete();

  //   return [];
  // }

  public function edit($id, Content $content)
  {
    return $content
      ->title($this->title())
      ->description($this->description['edit'] ?? trans('admin.edit'))
      ->body($this->form()->edit($id));
  }

  // 编辑 分类
  public function admin_edit_categories(Category $id,Request $request){
    $data=$request->all();
    
    
    $id->update($data);
  

    return[];
  }
  // 新增 分类
  public function admin_create_categories(Category $category,Request $request){
    $data=$request->all();

    // $category->name=$data['name'];
    // $category->description=$data['description'];
    
    $category->fill($data);
    $category->save();

    return [];
  }

 
}
