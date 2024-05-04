<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInfosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('factural_name', 50);
            $table->string('factural_address', 50);
            $table->string('factural_postal_code', 12);
            $table->string('factural_city', 50);
            $table->string('factural_phone_number', 20);
            $table->string('billing_name', 50);
            $table->string('billing_address', 50);
            $table->string('billing_postal_code', 12);
            $table->string('billing_city', 50);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_infos');
    }
};
