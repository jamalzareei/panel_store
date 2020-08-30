<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable()->index();
            $table->string('name', 255)->nullable()->index();
            $table->string('slug', 255)->nullable()->unique()->index();
            $table->string('icon', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('head', 255)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamp('active_at')->nullable();
            $table->integer('is_filter')->default(0)->index();
            $table->text('filter_list')->nullable();
            $table->text('default_list')->nullable();
            $table->integer('is_show_less')->default(0)->index();
            $table->integer('is_price')->default(0)->index();
            $table->bigInteger('website_id')->nullable()->index();
            $table->integer('order_by')->default(1);
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
        Schema::dropIfExists('properties');
    }
}
