<?php

use App\Models\Basket;
use App\Models\UserData;
use Faker\Provider\Base;
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
        Schema::create(Basket::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId(Basket::USER_ID)->constrained(UserData::TABLE_NAME)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Basket::TABLE_NAME);
    }
};
