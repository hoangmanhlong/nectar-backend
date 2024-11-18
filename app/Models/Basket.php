<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    const TABLE_NAME = 'basket';

    const USER_ID = 'user_id';

    const ID = 'id';

    protected $table = self::TABLE_NAME;

    public function userData() {
        return $this->belongsTo(
            related: UserData::class,
            foreignKey: UserData::ID,
            ownerKey: self::USER_ID
        );
    }

    public function products() {
        return $this->hasMany(
            BasketItem::class,
            foreignKey: BasketItem::BASKET_ID,
            localKey: self::ID
        );
    }
}
