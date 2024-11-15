<?php

use App\Models\Area;
use App\Models\Zone;
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
        Schema::create(Area::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(Area::NAME);
            $table->foreignId(Area::ZONE_ID)->constrained(Zone::TABLE_NAME)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Area::TABLE_NAME);
    }
};
