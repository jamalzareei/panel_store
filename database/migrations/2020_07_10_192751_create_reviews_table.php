<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id()->index();
            $table->string('ip');
            $table->text('user_agent');
            $table->string('name');
            $table->string('email');
            $table->bigInteger('user_id')->nullabl();
            $table->integer('rate');
            $table->string('link_page');
            $table->string('reply_admin')->nullable();
            $table->string('parent_id')->default(0);
            $table->integer('active')->default(0);
            $table->morphs('reviewable');
            $table->string('type', 30)->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
