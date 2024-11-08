<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    const TABLE_NAME = 'favorite_products';

    const ID = 'id';

    const USER_ID = 'user_id';

    const PRODUCT_ID = 'product_id';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    protected $fillable = [
        self::USER_ID,
        self::PRODUCT_ID
    ];

    public static function createFavoriteProduct(int $userId, int $productId) {
        return self::create([
            self::PRODUCT_ID => $productId,
            self::USER_ID => $userId
        ]);
    }

    public static function deleteFavoriteProduct(int $userId, int $productId) {
        self::where(self::USER_ID, $userId)
            ->where(self::PRODUCT_ID, $productId)
            ->first()
            ->delete();
    }
}
