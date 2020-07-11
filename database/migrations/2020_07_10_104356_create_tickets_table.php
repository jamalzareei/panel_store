<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_sender_id')->index();
            $table->bigInteger('user_receiver_id')->nullable()->index();
            $table->string('user_receiver_type', 255)->nullable()->index();
            $table->bigInteger('group_chat_id')->nullable()->index();
            $table->bigInteger('status_id')->index();
            $table->string('title', 255)->nullable()->index();
            $table->text('message');
            $table->text('path')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
