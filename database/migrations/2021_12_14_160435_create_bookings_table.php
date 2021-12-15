<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('goods_id')->unsigned()->index();    // 商品id
            $table->bigInteger('user_id')->unsigned()->index();     // 商品所属用户id
            $table->bigInteger('buyer_id')->unsigned()->index();     // 预订者id

            $table->string('user_state',2);   // 卖家状态-0：拒绝出售，1：同意
            $table->string('reason')->nullable();   // 拒绝的原因

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
