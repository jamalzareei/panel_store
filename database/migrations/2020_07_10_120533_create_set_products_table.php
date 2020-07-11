<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index();
            $table->string('slug', 255)->index();
            $table->string('title', 255)->nullable();
            $table->string('head', 255)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('shixeh_show')->default(1);
            $table->bigInteger('admin_id')->nullable();
            $table->bigInteger('website_id')->nullable()->index();
            $table->integer('active')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        
        Schema::create('product_set_product', function (Blueprint $table) {
            $table->bigInteger('set_product_id');
            $table->bigInteger('product_id');
        });

        Schema::create('category_set_product', function (Blueprint $table) {
            $table->bigInteger('set_product_id');
            $table->bigInteger('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('set_products');
        Schema::dropIfExists('product_set_product');
        Schema::dropIfExists('category_set_product');
    }
}
