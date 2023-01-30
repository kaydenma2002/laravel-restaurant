<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->nullable();
            $table->string('name')->default('kayden');
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->string('food_type')->nullable();;
            $table->string('image')->nullable();;
            $table->string('title')->nullable();;
            $table->unsignedBigInteger('menu_id')->unsigned()->nullable();
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
