<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasketItem extends Model
{

    const TABLE_NAME = 'basket_items';

    const ID = 'id';

    const PRODUCT_ID = 'product_id';

    const BASKET_ID = 'basket_id';

    const QUANTITY = 'quantity';

    protected $table = self::TABLE_NAME;

    public function basket() {
        $this->belongsTo(
            related: Basket::class,
            foreignKey: Basket::ID,
            ownerKey: self::BASKET_ID
        );
    }
}
