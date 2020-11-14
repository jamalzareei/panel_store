<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('seller_id')->nullable();
            $table->string('name', 255);
            $table->string('bank', 255);
            $table->string('bank_cart_number', 30)->nullable();
            $table->string('bank_sheba_number', 30)->nullable();
            $table->string('bank_account_number', 30)->nullable();
            $table->timestamp('actived_at')->nullable();
            $table->integer('order_by')->default(1);
            $table->bigInteger('website_id')->nullable()->index();
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
        Schema::dropIfExists('finances');
    }
}
