<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',255);
            $table->text('description');      // 商品描述
            $table->string('image');   // 商品图片
            $table->string('state');     // 商品状态(0-未发布，1-发布且正在售卖，2-发布且被预订，3-发布且已出售)
            $table->decimal('price', 5, 1);   // 商品价格，最大9999.9
            $table->decimal('old_price', 5, 1)->nullable();   // 商品价格，最大9999.9
            $table->integer('view_count')->unsigned()->default(0);    // 浏览量
            $table->integer('reply_count')->unsigned()->default(0);     // 评论数量
            $table->integer('category_id')->unsigned()->index();    // 商品类别id
            $table->bigInteger('user_id')->unsigned()->index();     // 商品所属用户id
            $table->timestamps();
        });
    }

    public function down()
    {
      Schema::dropIfExists('goods');

    }
}
