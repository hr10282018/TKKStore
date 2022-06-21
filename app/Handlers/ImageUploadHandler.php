<?php

namespace App\Handlers;

use Image;
use Str;

class ImageUploadHandler
{
  protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];
  /*
      $file-上传的图片对象
      $folder-文件夹名，存储到哪个文件夹
      $file_prefix-文件名：用户id+time+随机10位数字
      $max_width-限制图像的尺寸
    */
  public function save($file, $folder, $file_prefix, $max_width = false)
  {
    // 存储的文件夹格式，如：uploads/images/goods/202112/07/
    // 文件夹切割  提高效率
    $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

    // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
    // 如：/home/vagrant/Code/project/onestore/public/uploads/images/goods/202112/07/
    $upload_path = public_path() . '/' . $folder_name;

    // 文件的后缀名，若没有则为png，(可能考虑黏贴)
    $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

    // 拼接文件。如：1_1493521050_7BVc9v9ujP.png  id+time+随机字符
    $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

    // 不是图片则返回
    if (!in_array($extension, $this->allowed_ext)) {
      return false;
    }

    // 图片移动存储路径
    $file->move($upload_path, $filename);

    // 如果限制图片宽度，则裁剪
    if ($max_width && $extension != 'gif') {

      // 调用定义函数
      $this->reduceSize($upload_path . '/' . $filename, $max_width);
    }

    return [
      'path' => config('app.url') . "/$folder_name/$filename"
    ];
  }

  // 定义函数-用于裁剪图片  （z暂时不考虑）
  public function reduceSize($file_path, $max_width)
  {
    //dd($file_path);
    // 先实例化，传参是文件的磁盘物理路径
    $image = Image::make($file_path);

    // 进行大小调整的操作
    // $image->resize($max_width, null, function ($constraint) {   

    //   // 设定宽度是 $max_width，高度等比例缩放
    //   $constraint->aspectRatio();

    //   // 防止裁图时图片尺寸变大
    //   $constraint->upsize();
    // });
    
    // 头像 裁剪
    if( strstr('avatars',$file_path)){
      $image->resize(300, 300);   // 
    }
    
    // 对图片修改后进行保存
    $image->save();
  }
}
