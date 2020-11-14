<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable()->index();
            $table->string('slug', 255)->nullable()->unique()->index();
            $table->string('icon', 255)->nullable();
            $table->text('image')->nullable();
            $table->longText('description_full')->nullable();
            $table->text('description_short')->nullable();
            // $table->string('title', 255)->nullable();
            // $table->string('head', 255)->nullable();
            // $table->text('meta_keywords')->nullable();
            // $table->text('meta_description')->nullable();
            $table->timestamp('actived_at')->nullable();
            $table->integer('show_menu')->default(1);
            $table->integer('properties_active')->default(0);
            $table->bigInteger('website_id')->nullable()->index();
            $table->bigInteger('parent_id')->nullable()->index();
            $table->text('link')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
