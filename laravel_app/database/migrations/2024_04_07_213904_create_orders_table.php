<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('customer_info_id');
            $table->unsignedBigInteger('delivery_info_id');
            $table->unsignedBigInteger('payment_info_id');
            $table->float('totalPrice');
            $table->dateTime('createdAt');
            $table->timestamps();
            $table->string('state');

            $table->foreign('cart_id')->references('id')->on('shopping_carts')->onDelete('cascade');
            $table->foreign('customer_info_id')->references('id')->on('customer_infos')->onDelete('cascade');
            $table->foreign('delivery_info_id')->references('id')->on('delivery_infos')->onDelete('cascade');
            $table->foreign('payment_info_id')->references('id')->on('payment_infos')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};