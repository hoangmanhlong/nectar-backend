<?php

use App\Models\ProductCategory;
use App\Models\ProductCategoryImage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * php artisan migrate --path=database/migrations/2024_11_03_033836_create_product_categories_table.php
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(ProductCategory::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(ProductCategory::NAME);
            $table->string(ProductCategory::COLOR);
            $table->foreignId(ProductCategory::CATEGORY_IMAGE_ID)->constrained(ProductCategoryImage::TABLE_NAME, ProductCategoryImage::ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ProductCategory::TABLE_NAME);
    }
};
