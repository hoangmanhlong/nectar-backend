<?php

use App\Models\Area;
use App\Models\UserData;
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
        Schema::create(UserData::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(UserData::USERNAME);
            $table->string(UserData::EMAIl);
            $table->foreignId(UserData::ZONE_ID)->nullable()->constrained(Zone::TABLE_NAME, Zone::ID);
            $table->foreignId(UserData::AREA_ID)->nullable()->constrained(Area::TABLE_NAME, Area::ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(UserData::TABLE_NAME);
    }
};
