<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_shows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->index();
            $table->morphs('website_show_type');
            $table->morphs('website_show_id');
            $table->string('type', 30)->nullable();
            $table->timestamp('active_at')->nullable();
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
        Schema::dropIfExists('website_shows');
    }
}
