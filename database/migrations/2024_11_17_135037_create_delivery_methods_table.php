<?php

use App\Models\DeliveryMethod;
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
        Schema::create(DeliveryMethod::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(DeliveryMethod::NAME);
            $table->integer(DeliveryMethod::CODE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DeliveryMethod::TABLE_NAME);
    }
};
