<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->string('first_name', 50);
            $table->string('surname', 50);
            $table->string('email', 256)->unique();
            $table->string('password', 256);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('shopping_carts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
