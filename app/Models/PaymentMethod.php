<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    const TABLE_NAME = 'payment_methods';

    const ID = 'id';

    const CODE = 'code';

    const NAME = 'name';

    const IMAGE_URL = 'image_url';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];
}
