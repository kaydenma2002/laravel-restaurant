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
        Schema::create('cart_before_logins', function (Blueprint $table) {
            $table->id();
            $table->string('cookie');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('restaurant_id')->unsigned()->nullable();
            $table->integer('quantity');
            $table->foreign('item_id')->references('id')->on('items');

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
        Schema::dropIfExists('cart_before_login');
    }
};
