<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    const TABLE_NAME = 'order_products';

    const ID = 'id';

    const ORDER_ID = 'order_id';

    const PRODUCT_ID = 'product_id';

    const QUANTITY = 'quantity';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
