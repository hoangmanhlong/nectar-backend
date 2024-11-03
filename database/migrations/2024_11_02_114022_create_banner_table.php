<?php

use App\Models\Banner;
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
        Schema::create(Banner::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(Banner::TITLE);
            $table->string(Banner::IMAGE_URL)->unique();
            $table->integer(Banner::DISPLAY_PRIORITY)->default(Banner::DISPLAY_PRIORITIES['low']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Banner::TABLE_NAME);
    }
};
