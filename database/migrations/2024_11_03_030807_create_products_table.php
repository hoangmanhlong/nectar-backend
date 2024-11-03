<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use GuzzleHttp\Handler\Proxy;
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
        Schema::create(Product::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(Product::NAME);
            $table->string(Product::DESCRIPTION);
            $table->string(Product::UNIT_OF_MEASURE);
            $table->double(Product::PRICE);
            $table->string(Product::NUTRIENTS);
            $table->integer(Product::RATING);
            $table->integer(Product::STOCK);
            $table->foreignId(Product::CATEGORY_ID)->constrained(ProductCategory::TABLE_NAME, ProductCategory::ID);
            $table->foreignId(Product::THUMBNAIL_ID)->constrained(ProductImage::TABLE_NAME, ProductImage::ID);
            $table->integer(Product::SOLD);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Product::TABLE_NAME);
    }
};
