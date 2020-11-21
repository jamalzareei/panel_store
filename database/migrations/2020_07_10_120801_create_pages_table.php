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
            $table->bigInteger('user_id');
            $table->string('name', 255)->index();
            $table->string('slug', 255)->index();
            $table->string('icon', 255)->nullable();
            $table->text('image_path')->nullable();
            $table->text('path')->nullable();
            $table->text('tags')->nullable();
            $table->integer('shixeh_show')->default(1);
            $table->timestamp('actived_at')->nullable();
            $table->timestamp('admin_actived_at')->nullable();
            $table->bigInteger('admin_actived_id')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
