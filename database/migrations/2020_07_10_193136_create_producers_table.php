<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug')->unique()->index();
            $table->string('user_id')->nullable();
            $table->string('manager')->nullable();
            $table->string('phones')->nullable();
            $table->integer('country_id')->nullable()->index();
            $table->integer('state_id')->nullable()->index();
            $table->integer('city_id')->nullable()->index();
            $table->text('address')->nullable();
            $table->text('about')->nullable();
            $table->integer('shipping_cost')->default(0);
            $table->integer('time_transfor')->default(0);
            $table->timestamp('tell_verified_at')->nullable();
            $table->timestamp('active_verified_at')->nullable();
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
        Schema::dropIfExists('producers');
    }
}
