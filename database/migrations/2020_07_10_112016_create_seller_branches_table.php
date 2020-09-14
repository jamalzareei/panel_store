<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_branches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->bigInteger('seller_id')->index();
            $table->bigInteger('country_id')->nullable()->index();
            $table->bigInteger('state_id')->nullable()->index();
            $table->bigInteger('city_id')->nullable()->index();
            $table->string('title', 255)->nullable();
            $table->string('manager', 255)->nullable();
            $table->string('phones', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('latitude', 255)->nullable();
            $table->string('longitude', 255)->nullable();
            $table->timestamp('actived_at')->nullable();
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
        Schema::dropIfExists('seller_branches');
    }
}
