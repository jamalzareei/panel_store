<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->string('code', 255);
            $table->bigInteger('country_id')->nullable()->index();
            $table->bigInteger('state_id')->nullable()->index();
            $table->bigInteger('city_id')->nullable()->index();
            $table->bigInteger('role_id')->nullable();
            $table->string('sell_type_id')->nullable();
            $table->string('pay_type_id')->nullable();
            $table->bigInteger('admin_active_id');
            $table->integer('active')->default(0)->index();
            $table->timestamp('expire_at')->nullable();
            $table->timestamp('call_admin_at')->nullable();
            $table->string('name', 255)->nullable()->index();
            $table->string('slug', 255)->nullable()->unique()->index();
            $table->string('website', 255)->nullable()->index();
            $table->string('manager', 255)->nullable();
            $table->text('title')->nullable();
            $table->text('head')->nullable();
            $table->longText('details')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
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
        Schema::dropIfExists('sellers');
    }
}
