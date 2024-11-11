<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    const TABLE_NAME = 'product_rating';

    const ID = 'id';

    const USER_ID = 'user_id';

    const PRODUCT_ID = 'product_id';

    const RATING = 'rating';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::USER_ID,
        self::PRODUCT_ID,
        self::RATING
    ];
}
