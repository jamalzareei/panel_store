<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index();
            $table->string('slug', 255)->index();
            $table->string('icon', 255)->nullable();
            $table->text('image')->nullable();
            $table->text('path')->nullable();
            // $table->string('title', 255)->nullable();
            // $table->string('head', 255)->nullable();
            // $table->text('meta_keywords')->nullable();
            // $table->text('meta_description')->nullable();
            $table->timestamp('actived_at')->nullable();
            $table->integer('shixeh_show')->default(1);
            $table->bigInteger('admin_actived_id');
            $table->bigInteger('website_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('product_tag', function (Blueprint $table) {
            $table->bigInteger('product_id')->index();
            $table->bigInteger('tag_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('product_tag');
    }
}
