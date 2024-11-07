<?php

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
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
        Schema::create(BasketItem::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->integer(BasketItem::QUANTITY);
            $table->foreignId(BasketItem::PRODUCT_ID)->constrained(Product::TABLE_NAME)->onDelete('cascade');
            $table->foreignId(BasketItem::BASKET_ID)->constrained(Basket::TABLE_NAME)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(BasketItem::TABLE_NAME);
    }
};
