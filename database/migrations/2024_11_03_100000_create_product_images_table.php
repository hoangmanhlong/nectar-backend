<?php

use App\Models\Product;
use App\Models\ProductImage;
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
        Schema::create(ProductImage::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(ProductImage::NAME);
            $table->string(ProductImage::IMAGE_URL);
            $table->foreignId(ProductImage::PRODUCT_ID)->constrained(Product::TABLE_NAME, Product::ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ProductImage::TABLE_NAME);
    }
};
