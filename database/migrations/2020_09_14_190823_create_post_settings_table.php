<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->bigInteger('seller_id')->index();
            $table->bigInteger('country_id');
            $table->bigInteger('state_id');
            $table->bigInteger('city_id')->nullable();
            $table->string('shipping_cost');
            $table->bigInteger('currency_id');
            $table->string('shipping_time');
            $table->string('unit_of_time');
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
        Schema::dropIfExists('post_settings');
    }
}
