<?php


use App\Models\Good;
use Faker\Generator as Faker;
use App\Models\Comment;

// 商品图片
$images = [
  'http://onestore.tkk/images/goods/1_x.jpg,http://onestore.tkk/images/goods/1_y.jpg,http://onestore.tkk/images/goods/1_z.jpg,',
  'http://onestore.tkk/images/goods/2_x.jpg,http://onestore.tkk/images/goods/2_y.jpg,',
  'http://onestore.tkk/images/goods/3_x.jpg,http://onestore.tkk/images/goods/3_y.jpg,',
  'http://onestore.tkk/images/goods/4_x.jpg,',
  'http://onestore.tkk/images/goods/5_x.jpg,http://onestore.tkk/images/goods/6_y.jpg,',
  'http://onestore.tkk/images/goods/7_x.jpg,http://onestore.tkk/images/goods/7_y.jpg,http://onestore.tkk/images/goods/7_z.jpg,',
  'http://onestore.tkk/images/goods/8_x.jpg,http://onestore.tkk/images/goods/8_y.jpg,http://onestore.tkk/images/goods/8_z.jpg,',
  'http://onestore.tkk/images/goods/9_x.jpg,',
  'http://onestore.tkk/images/goods/10_x.jpg,',
  'http://onestore.tkk/images/goods/11_x.jpg,http://onestore.tkk/images/goods/11_y.jpg,',
  'http://onestore.tkk/images/goods/12_x.jpg,',
  'http://onestore.tkk/images/goods/13_x.jpg,http://onestore.tkk/images/goods/13_y.jpg,',
  'http://onestore.tkk/images/goods/14_x.jpg,',
  'http://onestore.tkk/images/goods/15_x.jpg,http://onestore.tkk/images/goods/15_y.jpg,',
  'http://onestore.tkk/images/goods/16_x.jpg,',
  'http://onestore.tkk/images/goods/17_x.jpg,http://onestore.tkk/images/goods/17_y.jpg,',
];

// 商品标题
$title = [
  '下学期不在学校了 出出出',
  '资深堂睫毛夹，贴身衣物收纳盒，反光板金银双面，爱自拍可入',
  '出个原神号[悲伤]，活不起了，一个版本没玩了都。新的那个岛也没探呢。26黄。有效黄13个',
  '十元出俩圣诞投影灯全新，各位靓仔靓女很好出片的喔',
  '出几个闲置呦！',
  '联想小新pro16 R7-5800H GTX1650',
  '出生发液 + 好看的手镯',
  '全新耐克外套',
  '出一个电脑支架 ,铝合金材质,质量超好',
  '壳双十一买的，没用过',
  '随缘出书，带价来，也可以白嫖',
  '原价出一个火影忍者盲盒鸣人，在sm 买的，重复了内袋未拆。',
  '出一个e元素k620的青轴机械键盘 155买的九成新 可刀',
  '出闲置啦～',
  '出一本二手的西门子工业通信',
  '井河阿莎姬现货国产机娘，小瑕疵，盒子替换件都在100出全校可配送',
];

$factory->define(Good::class, function (Faker $faker) use ($images, $title) {


  $updated_at = $faker->dateTimeThisMonth(); //返回前一个月内的DateTime对象.
  $created_at = $faker->dateTimeThisMonth($updated_at); // 创建时间小于修改时间
  $index = $faker->numberBetween(0, 15); //生成随机整数，范围是0-100之间



  return [
    "title" => $title[$index],
    "description" => $faker->text(255), //返回一段文本，最多200字符
    "image" => $images[$index],
    "state" => $faker->randomElement([0, 1, 2, 3]),
    'user_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
    'category_id' => $faker->randomElement([1, 2, 3, 4]),
    "view_count" => $faker->numberBetween(100, 1000),
    "reply_count"  =>  3,
    "tags"  =>  '1-2-3',
    "price" => $faker->randomFloat(1, 1, 200),  //生成浮点数，两位小数点，范围1-200
    "old_price" => $faker->randomFloat(1, 10, 300),
    'created_at' => $created_at,
    'updated_at' => $updated_at,
  ];
});
