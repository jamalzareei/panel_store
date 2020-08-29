<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index();
            $table->string('slug', 255)->index();
            $table->string('icon', 255)->nullable();
            $table->text('image')->nullable();
            $table->text('path')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('head', 255)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('shixeh_show')->default(1);
            $table->bigInteger('admin_id')->nullable();
            $table->bigInteger('website_id')->nullable()->index();
            $table->integer('order_by')->default(1);
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
        Schema::dropIfExists('pages');
    }
}
