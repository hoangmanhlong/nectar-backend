<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    const TABLE_NAME = 'products_image';

    const ID = 'id';

    const TITLE = 'title';

    const IMAGE_URL = 'image_url';
 
    const PRODUCT_ID = 'product_id';

    const IS_THUMBNAIL = 'is_thumbnail';

    protected $table = self::TABLE_NAME;

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT,
        self::PRODUCT_ID
    ];

    protected $casts= [
        self::IS_THUMBNAIL => 'bool'
    ];

    public function product() {
        return $this->belongsTo(Product::class, Product::ID, self::PRODUCT_ID);
    }

    
}
