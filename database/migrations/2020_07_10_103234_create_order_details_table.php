<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->bigInteger('product_id')->index();
            $table->bigInteger('price_id')->index();
            $table->decimal('price', 20)->index();
            $table->bigInteger('seller_id');
            $table->bigInteger('admin_id');
            $table->bigInteger('status_id');
            $table->bigInteger('website_id')->index();
            $table->bigInteger('order_id')->index();
            $table->integer('amount');
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
        Schema::dropIfExists('order_details');
    }
}
