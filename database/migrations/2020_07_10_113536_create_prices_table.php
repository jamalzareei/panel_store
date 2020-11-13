<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->bigInteger('seller_id')->index();
            $table->bigInteger('product_id')->index();
            $table->bigInteger('amount');
            $table->bigInteger('price');
            $table->bigInteger('old_price');
            $table->bigInteger('currency_id')->default(1);
            $table->bigInteger('discount')->nullable()->index();
            $table->timestamp('start_discount_at')->nullable();
            $table->timestamp('end_discount_at')->nullable();
            $table->timestamp('actived_at')->nullable()->index();
            $table->integer('order_by')->default(1);
            $table->bigInteger('admin_actived_id')->nullable();
            $table->timestamp('admin_actived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
