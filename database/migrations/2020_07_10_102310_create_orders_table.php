<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->bigInteger('website_id')->nullable()->index();
            $table->bigInteger('status_id')->index();
            $table->bigInteger('address_id')->nullable();
            $table->bigInteger('discount_id')->nullable();
            $table->double('total', 5, 2)->nullable();
            $table->double('subtotal', 5, 2)->nullable();
            $table->double('tax_cost', 5, 2)->nullable();
            $table->double('shipping_cost', 5, 2)->nullable();
            $table->double('discount', 5, 2)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
