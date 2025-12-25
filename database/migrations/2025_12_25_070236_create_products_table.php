<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger(column: 'category_id')->unsigned();
            $table->foreignId('category_id')->references('id')->on('catgories')->onDelete('cascade');
            $table->bigInteger(column: 'brand_id')->unsigned();
            $table->foreignId('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_available')->default(false);
            $table->integer('amount')->default(0);
            $table->double('discount')->default(0)->nullable();
            $table->string('image');
            $table->timestamps();
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
