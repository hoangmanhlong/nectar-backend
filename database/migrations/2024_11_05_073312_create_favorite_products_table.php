<?php

use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Models\UserData;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * php artisan migrate --path=database/migrations/2024_11_05_073312_create_favorite_products_table.php
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(FavoriteProduct::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId(FavoriteProduct::USER_ID)->constrained(UserData::TABLE_NAME)->onDelete('cascade');
            $table->foreignId(FavoriteProduct::PRODUCT_ID)->constrained(Product::TABLE_NAME)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(FavoriteProduct::TABLE_NAME);
    }
};
