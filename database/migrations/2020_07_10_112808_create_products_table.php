<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('seller_id');
            $table->string('name', 255);
            $table->string('code', 255);
            $table->string('slug', 255)->unique();
            $table->integer('shixeh_show')->default(1);
            $table->text('tags')->nullable();
            $table->text('description_small')->nullable();
            $table->longText('description_full')->nullable();
            $table->bigInteger('admin_id')->nullable();
            $table->bigInteger('website_id')->nullable();
            $table->timestamp('admin_active_at')->nullable();
            $table->timestamp('actived_at')->nullable();
            $table->timestamp('start_sale_at')->nullable();
            $table->timestamp('end_sale_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('category_product', function (Blueprint $table) {
            $table->bigInteger('category_id');
            $table->bigInteger('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('category_product');
    }
}
