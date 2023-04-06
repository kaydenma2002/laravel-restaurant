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
            
            $table->string('name')->default('kayden');
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->string('category')->nullable();
            $table->string('edit')->nullable();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('note')->nullable();
            $table->unsignedBigInteger('restaurant_id')->unsigned()->nullable();
            $table->foreign('restaurant_id')->references('restaurant_id')->on('restaurants');
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
