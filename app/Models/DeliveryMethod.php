<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{

    const TABLE_NAME = 'delivery_methods';

    const ID = 'id';

    const CODE = 'code';

    const NAME = 'name';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
