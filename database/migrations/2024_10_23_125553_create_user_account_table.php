<?php

use App\Models\UserAccount;
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
        Schema::create(UserAccount::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(UserAccount::EMAIL)->unique();
            $table->string(UserAccount::PASSWORD);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(UserAccount::TABLE_NAME);
    }
};
