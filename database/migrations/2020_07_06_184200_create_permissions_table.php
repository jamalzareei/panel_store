<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('controller', 255)->nullable();
            $table->string('method', 255)->nullable();
            $table->string('key', 255)->nullable();
            $table->integer('active')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        
        Schema::create('permission_role', function (Blueprint $table) {
            $table->bigInteger('permission_id');
            $table->bigInteger('rol_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
