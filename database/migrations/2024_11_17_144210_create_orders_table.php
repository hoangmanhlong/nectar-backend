<?php

use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\OrderStatus;
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
        Schema::create(Order::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->double(Order::TOTAL_COST);
            $table->integer(Order::ORDER_TIME)->default(time());
            $table->foreignId(Order::ORDER_STATUS_ID)->constrained(OrderStatus::TABLE_NAME);
            $table->foreignId(Order::PAYMENT_METHOD_ID)->constrained(PaymentMethod::TABLE_NAME);
            $table->foreignId(Order::DELIVERY_METHOD_ID)->constrained(DeliveryMethod::TABLE_NAME);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Order::TABLE_NAME);
    }
};
