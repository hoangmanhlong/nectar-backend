<?php

use App\Models\Order;
use App\Models\OrderProduct;
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
        Schema::create(OrderProduct::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId(OrderProduct::ORDER_ID)->constrained(Order::TABLE_NAME);
            $table->foreignId(OrderProduct::PRODUCT_ID)->constrained(Product::TABLE_NAME);
            $table->integer(OrderProduct::QUANTITY);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(OrderProduct::TABLE_NAME);
    }
};
