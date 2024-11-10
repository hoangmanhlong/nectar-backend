<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    const TABLE_NAME = 'favorite_products';

    const ID = 'id';

    const USER_ID = 'user_id';

    const PRODUCT_ID = 'product_id';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    protected $fillable = [
        self::USER_ID,
        self::PRODUCT_ID
    ];
}
