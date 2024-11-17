<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    const TABLE_NAME = 'orders';

    const ID = 'id';

    const DELIVERY_METHOD_ID = 'delivery_method_id';

    const PAYMENT_METHOD_ID = 'payment_method_id';

    const ORDER_TIME = 'order_time';

    const TOTAL_COST = 'total_cost';

    const ORDER_STATUS_ID = 'order_status_id';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
