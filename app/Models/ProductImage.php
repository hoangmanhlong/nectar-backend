<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    const TABLE_NAME = 'products_image';

    const ID = 'id';

    const NAME = 'name';

    const IMAGE_URL = 'image_url';
 
    const PRODUCT_ID = 'product_id';

    const IS_THUMBNAIL = 'is_thumbnail';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    protected $casts= [
        self::IS_THUMBNAIL => 'bool'
    ];

    
}
