<?php

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table(Product::TABLE_NAME, function (Blueprint $table) {
            $table->foreign(Product::THUMBNAIL_ID)->references(ProductImage::ID)->on(ProductImage::TABLE_NAME);
        });
    }

    public function down(): void {
        Schema::table(Product::TABLE_NAME, function (Blueprint $table) {
            $table->dropForeign([Product::THUMBNAIL_ID]);
        });
    }
};

