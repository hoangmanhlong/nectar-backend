<?php

use App\Models\Product;
use App\Models\ProductRating;
use App\Models\UserData;
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
        Schema::create(ProductRating::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId(ProductRating::USER_ID)->constrained(UserData::TABLE_NAME);
            $table->foreignId(ProductRating::PRODUCT_ID)->constrained(Product::TABLE_NAME);
            $table->float(ProductRating::RATING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ProductRating::TABLE_NAME);
    }
};
