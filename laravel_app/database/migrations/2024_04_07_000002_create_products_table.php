<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->string('image', 256)->nullable();
            $table->string('description', 1000);
            $table->string('brand', 50);
            $table->string('device_type', 50);
            $table->string('color', 50);
            $table->float('price');
            $table->boolean('weekly_hit')->default(false);
            $table->unsignedInteger('category_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
