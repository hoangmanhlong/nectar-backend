<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    const TABLE_NAME = 'orders';

    const ID = 'id';

    const USER_ID = 'user_id';

    const DELIVERY_METHOD_ID = 'delivery_method_id';

    const PAYMENT_METHOD_ID = 'payment_method_id';

    const ORDER_STATUS_ID = 'order_status_id';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::ID,
        self::DELIVERY_METHOD_ID,
        self::PAYMENT_METHOD_ID,
        self::ORDER_STATUS_ID
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    public function userData() {
        return $this->belongsTo(
            related: UserData::class,
            foreignKey: UserData::ID,
            ownerKey: self::USER_ID
        );
    }

    public function deliveryMethod() {
        return $this->hasOne(DeliveryMethod::class, DeliveryMethod::ID, self::DELIVERY_METHOD_ID);
    }

    public function paymentMethod() {
        return $this->hasOne(PaymentMethod::class, PaymentMethod::ID, self::PAYMENT_METHOD_ID);
    }

    public function orderStatus() {
        return $this->hasOne(OrderStatus::class, OrderStatus::ID, self::ORDER_STATUS_ID);
    }

    public function orderProducts() {
        return $this->hasMany(
            OrderProduct::class,
            OrderProduct::ORDER_ID,
            self::ID
        );
    }
}
