<?php

use App\Models\ProductCategoryImage;
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
        Schema::create(ProductCategoryImage::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(ProductCategoryImage::TITLE);
            $table->string(ProductCategoryImage::IMAGE_URL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ProductCategoryImage::TABLE_NAME);
    }
};
