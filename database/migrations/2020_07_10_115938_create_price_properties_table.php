<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_properties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('price_id')->index();
            $table->bigInteger('product_id')->index();
            $table->bigInteger('property_id')->index();
            $table->string('value', 255)->index();
            $table->string('element_html', 255)->nullable();
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
        Schema::dropIfExists('price_properties');
    }
}
