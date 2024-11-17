<?php

use App\Models\PaymentMethod;
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
        Schema::create(PaymentMethod::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(PaymentMethod::NAME);
            $table->integer(PaymentMethod::CODE);
            $table->string(PaymentMethod::IMAGE_URL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(PaymentMethod::TABLE_NAME);
    }
};
